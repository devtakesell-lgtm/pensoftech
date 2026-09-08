<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // 1. Global Admin Access Permission
        Permission::firstOrCreate(
            ['name' => 'access-admin', 'guard_name' => 'web'],
            [
                'module' => 'general',
                'description' => 'Allows staff user to access the agency administration panel.',
            ]
        );

        // 2. Granular Module Permissions
        $modules = [
            'clients' => 'Client accounts and profiles',
            'leads' => 'Sales leads and inquiries',
            'projects' => 'Agency client projects',
            'quotes' => 'Service quotes and cost estimates',
            'blogs' => 'Articles and blog posts',
            'jobs' => 'Career openings and applications',
            'users' => 'Staff users and team members',
            'roles' => 'Roles and permission matrix management',
            'settings' => 'System and agency settings',
        ];

        $actions = ['view', 'create', 'edit', 'delete'];

        foreach ($modules as $module => $moduleDesc) {
            foreach ($actions as $action) {
                $name = "{$action}-{$module}";

                Permission::firstOrCreate(
                    ['name' => $name, 'guard_name' => 'web'],
                    [
                        'module' => $module,
                        'description' => "Allows user to {$action} {$module}.",
                    ]
                );
            }
        }
    }
}
