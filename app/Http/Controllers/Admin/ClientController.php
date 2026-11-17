<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreClientRequest;
use App\Http\Requests\Admin\UpdateClientRequest;
use App\Models\Client;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ClientController extends Controller
{
    /**
     * Display a listing of agency clients.
     */
    public function index(Request $request): View
    {
        Gate::authorize('view-clients');

        $search = $request->input('search');
        $status = $request->input('status');

        $clientsQuery = Client::with('user')->withCount('projects');

        if ($search) {
            $clientsQuery->where(function ($query) use ($search) {
                $query->where('company_name', 'like', "%{$search}%")
                    ->orWhere('contact_person', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->where('email', 'like', "%{$search}%");
                    });
            });
        }

        if ($status === 'active') {
            $clientsQuery->where('is_active', true);
        } elseif ($status === 'inactive') {
            $clientsQuery->where('is_active', false);
        }

        $clients = $clientsQuery->latest()->paginate(10)->withQueryString();

        $totalCount = Client::count();
        $activeCount = Client::where('is_active', true)->count();

        return view('admin.pages.clients.index')->with([
            'clients' => $clients,
            'totalCount' => $totalCount,
            'activeCount' => $activeCount,
            'currentSearch' => $search ?? '',
            'currentStatus' => $status ?? 'All Status',
        ]);
    }

    /**
     * Store a newly created client.
     */
    public function store(StoreClientRequest $request): RedirectResponse
    {
        Gate::authorize('create-clients');

        DB::transaction(function () use ($request) {
            $password = Str::random(12);
            $role = Role::where('name', 'client')->first();

            $user = User::create([
                'name' => $request->contact_person,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($password),
                'role_id' => $role ? $role->id : null,
                'is_active' => true,
            ]);

            if ($role) {
                $user->assignRole($role);
            }

            Client::create([
                'user_id' => $user->id,
                'company_name' => $request->company_name,
                'contact_person' => $request->contact_person,
                'website' => $request->website,
                'phone' => $request->phone,
                'is_active' => true,
            ]);
        });

        return redirect()->route('admin.clients')
            ->with('success', "Client '{$request->company_name}' has been successfully created.");
    }

    /**
     * Display the specified client.
     */
    public function show(Client $client): View
    {
        Gate::authorize('view-clients');

        $client->load(['user', 'projects', 'leads']);

        return view('admin.pages.clients.show')->with([
            'client' => $client,
        ]);
    }

    /**
     * Show the form for editing the specified client.
     */
    public function edit(Client $client): View
    {
        Gate::authorize('edit-clients');

        return view('admin.pages.clients.edit')->with([
            'client' => $client,
        ]);
    }

    /**
     * Update the specified client in storage.
     */
    public function update(UpdateClientRequest $request, Client $client): RedirectResponse
    {
        Gate::authorize('edit-clients');

        DB::transaction(function () use ($request, $client) {
            $client->user->update([
                'name' => $request->contact_person,
                'email' => $request->email,
                'phone' => $request->phone,
            ]);

            $client->update($request->validated());
        });

        return redirect()->route('admin.clients')
            ->with('success', "Client '{$client->company_name}' has been successfully updated.");
    }

    /**
     * Remove the specified client from storage.
     */
    public function destroy(Client $client): RedirectResponse
    {
        Gate::authorize('delete-clients');

        $companyName = $client->company_name;

        DB::transaction(function () use ($client) {
            if ($client->user) {
                $client->user->delete();
            }
            $client->delete();
        });

        return redirect()->route('admin.clients')
            ->with('success', "Client '{$companyName}' has been deleted.");
    }
}
