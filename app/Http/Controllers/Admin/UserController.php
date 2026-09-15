<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Spatie\Permission\PermissionRegistrar;

class UserController extends Controller
{
    /**
     * Display a listing of agency team members and users.
     */
    public function index(Request $request): View
    {
        Gate::authorize('view-users');

        $query = User::with('roles')->latest();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role')) {
            $roleName = $request->input('role');
            $query->whereHas('roles', function ($q) use ($roleName) {
                $q->where('name', $roleName);
            });
        }

        if ($request->filled('status')) {
            $isActive = $request->input('status') === 'active';
            $query->where('is_active', $isActive);
        }

        $users = $query->paginate(10)->withQueryString();
        $roles = Role::where('name', '!=', 'client')->orderBy('name')->get();

        return view('admin.pages.users.index')->with([
            'users' => $users,
            'roles' => $roles,
            'currentSearch' => $request->input('search', ''),
            'currentRole' => $request->input('role', ''),
            'currentStatus' => $request->input('status', ''),
        ]);
    }

    /**
     * Show the form for creating a new team user.
     */
    public function create(): View
    {
        Gate::authorize('create-users');

        $roles = Role::where('name', '!=', 'client')->orderBy('name')->get();

        return view('admin.pages.users.create')->with([
            'roles' => $roles,
        ]);
    }

    /**
     * Store a newly created team user in storage.
     */
    public function store(StoreUserRequest $request): RedirectResponse
    {
        Gate::authorize('create-users');

        $role = Role::findOrFail($request->validated('role_id'));

        $user = User::create([
            'role_id' => $role->id,
            'name' => $request->validated('name'),
            'email' => $request->validated('email'),
            'phone' => $request->validated('phone'),
            'password' => Hash::make($request->validated('password')),
            'is_active' => $request->boolean('is_active', true),
        ]);

        $user->syncRoles([$role]);

        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        return redirect()->route('admin.users')->with('success', "User '{$user->name}' created and assigned '{$role->name}' role successfully.");
    }

    /**
     * Show the form for editing an existing team user.
     */
    public function edit(User $user): View
    {
        Gate::authorize('edit-users');

        $user->load('roles');
        $roles = Role::where('name', '!=', 'client')->orderBy('name')->get();

        return view('admin.pages.users.edit')->with([
            'user' => $user,
            'roles' => $roles,
        ]);
    }

    /**
     * Update the specified team user in storage and re-assign role.
     */
    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        Gate::authorize('edit-users');

        $newRoleId = (int) $request->validated('role_id');
        $newRole = Role::findOrFail($newRoleId);
        $newIsActive = $request->boolean('is_active', true);

        // Guardrail: prevent demoting or deactivating the last remaining active administrator
        if ($user->hasRole('administrator')) {
            $isDemoting = $newRole->name !== 'administrator';
            $isDeactivating = ! $newIsActive && $user->is_active;

            if ($isDemoting || $isDeactivating) {
                $activeAdminCount = User::where('is_active', true)
                    ->whereHas('roles', fn ($q) => $q->where('name', 'administrator'))
                    ->count();
                if ($activeAdminCount <= 1) {
                    return back()->withInput()->with('error', 'Cannot demote or deactivate the last remaining active administrator.');
                }
            }
        }

        $user->name = $request->validated('name');
        $user->email = $request->validated('email');
        $user->phone = $request->validated('phone');
        $user->is_active = $newIsActive;
        $user->role_id = $newRole->id;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->validated('password'));
        }

        $user->save();
        $user->syncRoles([$newRole]);

        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        return redirect()->route('admin.users')->with('success', "User '{$user->name}' updated successfully.");
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user): RedirectResponse
    {
        Gate::authorize('delete-users');

        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users')->with('error', 'You cannot delete your own account.');
        }

        if ($user->hasRole('administrator')) {
            $activeAdminCount = User::where('is_active', true)
                ->whereHas('roles', fn ($q) => $q->where('name', 'administrator'))
                ->count();
            if ($activeAdminCount <= 1) {
                return redirect()->route('admin.users')->with('error', 'Cannot delete the last remaining active administrator.');
            }
        }

        $userName = $user->name;
        $user->delete();

        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        return redirect()->route('admin.users')->with('success', "User '{$userName}' deleted successfully.");
    }
}
