<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreRoleRequest;
use App\Http\Requests\Admin\UpdateRoleRequest;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Spatie\Permission\PermissionRegistrar;

class RoleController extends Controller
{
    /**
     * Display a listing of agency roles.
     */
    public function index(): View
    {
        $roles = Role::with('permissions')
            ->withCount('users')
            ->orderBy('name')
            ->get();

        return view('admin.pages.roles.index')->with([
            'roles' => $roles,
        ]);
    }

    /**
     * Show the form for creating a new role.
     */
    public function create(): View
    {
        $permissionsByModule = Permission::all()->groupBy('module');

        return view('admin.pages.roles.create')->with([
            'permissionsByModule' => $permissionsByModule,
        ]);
    }

    /**
     * Store a newly created role with its assigned permissions.
     */
    public function store(StoreRoleRequest $request): RedirectResponse
    {
        $roleName = Str::slug($request->validated('name'));

        $role = Role::create([
            'name' => $roleName,
            'guard_name' => 'web',
            'description' => $request->validated('description'),
            'is_active' => true,
        ]);

        $role->syncPermissions($request->validated('permissions', []));

        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        return redirect()->route('admin.roles.index')->with('success', "Role '{$role->name}' created successfully.");
    }

    /**
     * Show the form for editing an existing role.
     */
    public function edit(Role $role): View
    {
        $role->load('permissions');
        $permissionsByModule = Permission::all()->groupBy('module');
        $rolePermissionNames = $role->permissions->pluck('name')->toArray();

        return view('admin.pages.roles.edit')->with([
            'role' => $role,
            'permissionsByModule' => $permissionsByModule,
            'rolePermissionNames' => $rolePermissionNames,
        ]);
    }

    /**
     * Update the role and its assigned permissions.
     */
    public function update(UpdateRoleRequest $request, Role $role): RedirectResponse
    {
        // Protect system roles from having their slug changed
        if (! in_array($role->name, ['administrator', 'client'], true)) {
            $role->name = Str::slug($request->validated('name'));
        }

        $role->description = $request->validated('description');
        $role->save();

        // Administrator always maintains full access
        if ($role->name === 'administrator') {
            $role->syncPermissions(Permission::all());
        } else {
            $role->syncPermissions($request->validated('permissions', []));
        }

        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        return redirect()->route('admin.roles.index')->with('success', "Role '{$role->name}' updated successfully.");
    }

    /**
     * Remove the specified custom role.
     */
    public function destroy(Role $role): RedirectResponse
    {
        if (in_array($role->name, ['administrator', 'client'], true)) {
            return redirect()->route('admin.roles.index')->with('error', 'Core system roles cannot be deleted.');
        }

        if ($role->users()->count() > 0) {
            return redirect()->route('admin.roles.index')->with('error', 'Cannot delete a role that currently has assigned team members.');
        }

        $role->delete();

        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        return redirect()->route('admin.roles.index')->with('success', "Role '{$role->name}' deleted successfully.");
    }
}
