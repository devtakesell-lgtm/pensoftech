<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClientLoginRequest;
use App\Http\Requests\ClientRegisterRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AuthController extends Controller
{
    /**
     * Show the public client login form.
     */
    public function showLoginForm(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }

        return view('frontend.auth.login');
    }

    /**
     * Handle the client login request.
     */
    public function login(ClientLoginRequest $request): RedirectResponse
    {
        $throttleKey = Str::transliterate(Str::lower($request->input('email')).'|'.$request->ip());

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);

            throw ValidationException::withMessages([
                'email' => trans('auth.throttle', [
                    'seconds' => $seconds,
                    'minutes' => (int) ceil($seconds / 60),
                ]),
            ]);
        }

        $credentials = $request->only('email', 'password');
        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            /** @var User $user */
            $user = Auth::user();

            if (! $user->is_active) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                throw ValidationException::withMessages([
                    'email' => 'Your account has been deactivated. Please contact support.',
                ]);
            }

            RateLimiter::clear($throttleKey);
            $request->session()->regenerate();

            if ($user->role?->slug !== 'client') {
                return redirect()->intended(route('admin.dashboard'));
            }

            return redirect()->intended(route('home'));
        }

        RateLimiter::hit($throttleKey);

        throw ValidationException::withMessages([
            'email' => trans('auth.failed'),
        ]);
    }

    /**
     * Show the public client registration form.
     */
    public function showRegisterForm(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }

        return view('frontend.auth.register');
    }

    /**
     * Handle public client self-registration.
     */
    public function register(ClientRegisterRequest $request): RedirectResponse
    {
        $user = DB::transaction(function () use ($request) {
            $clientRole = Role::firstOrCreate(
                ['slug' => 'client'],
                [
                    'name' => 'Client',
                    'description' => 'Client account for portal and project tracking.',
                    'is_active' => true,
                ]
            );

            $newUser = User::create([
                'role_id' => $clientRole->id,
                'name' => $request->validated('name'),
                'email' => $request->validated('email'),
                'phone' => $request->validated('phone'),
                'password' => Hash::make($request->validated('password')),
                'is_active' => true,
            ]);

            $newUser->client()->create([
                'company_name' => $request->validated('company_name') ?: $request->validated('name'),
                'contact_person' => $request->validated('name'),
                'is_active' => true,
            ]);

            return $newUser;
        });

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('home')->with('status', 'Welcome to PenSoftTech! Your client account has been created.');
    }

    /**
     * Log out the client.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('status', 'You have been successfully signed out.');
    }
}
