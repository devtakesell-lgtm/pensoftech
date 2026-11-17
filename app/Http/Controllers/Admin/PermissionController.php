<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class PermissionController extends Controller
{
    /**
     * Display a module-categorized overview of all system permissions.
     */
    public function index(): View
    {
        Gate::authorize('view-roles');

        $permissions = Permission::with('roles')
            ->orderBy('module')
            ->orderBy('name')
            ->get();

        $permissionsByModule = $permissions->groupBy('module');

        return view('admin.pages.permissions.index')->with([
            'permissionsByModule' => $permissionsByModule,
        ]);
    }
}
