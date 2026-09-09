<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create the core roles
        $roles = [
            [
                'name' => 'administrator',
                'description' => 'Full access to all agency modules and settings.',
            ],
            [
                'name' => 'sales-manager',
                'description' => 'Manages leads, client requests, and cost estimates.',
            ],
            [
                'name' => 'project-manager',
                'description' => 'Oversees ongoing projects, clients, and execution.',
            ],
            [
                'name' => 'developer',
                'description' => 'Assigned technical tasks and project development.',
            ],
            [
                'name' => 'designer',
                'description' => 'Creative and UI/UX design deliverables.',
            ],
            [
                'name' => 'content-writer',
                'description' => 'Writes blog posts and marketing content.',
            ],
            [
                'name' => 'client',
                'description' => 'External client account for portal and project tracking.',
            ],
        ];

        $createdRoles = [];

        foreach ($roles as $roleData) {
            $createdRoles[$roleData['name']] = Role::firstOrCreate(
                ['name' => $roleData['name'], 'guard_name' => 'web'],
                [
                    'description' => $roleData['description'],
                    'is_active' => true,
                ]
            );
        }

        // 2. Permission Matrix Mapping
        // Administrator: Full access to everything
        $createdRoles['administrator']->syncPermissions(Permission::all());

        // Sales Manager: Admin access, leads, quotes, clients, services, case studies, industries
        $createdRoles['sales-manager']->syncPermissions([
            'access-admin',
            'view-leads', 'create-leads', 'edit-leads', 'delete-leads',
            'view-quotes', 'create-quotes', 'edit-quotes', 'delete-quotes',
            'view-clients',
            'view-services',
            'view-case-studies',
            'view-industries',
            'view-analytics',
        ]);

        // Project Manager: Admin access, projects, clients, and view leads/quotes/services/case studies
        $createdRoles['project-manager']->syncPermissions([
            'access-admin',
            'view-projects', 'create-projects', 'edit-projects', 'delete-projects',
            'view-clients', 'create-clients', 'edit-clients',
            'view-leads',
            'view-quotes',
            'view-services',
            'view-case-studies',
            'view-industries',
        ]);

        // Developer: Admin access + project tracking + services
        $createdRoles['developer']->syncPermissions([
            'access-admin',
            'view-projects',
            'edit-projects',
            'view-services',
        ]);

        // Designer: Admin access + project tracking + services
        $createdRoles['designer']->syncPermissions([
            'access-admin',
            'view-projects',
            'edit-projects',
            'view-services',
        ]);

        // Content Writer: Admin access + blogs + pages + case studies
        $createdRoles['content-writer']->syncPermissions([
            'access-admin',
            'view-blogs', 'create-blogs', 'edit-blogs', 'delete-blogs',
            'view-pages', 'create-pages', 'edit-pages',
            'view-case-studies', 'create-case-studies', 'edit-case-studies',
        ]);

        // Client: External portal only, zero admin permissions
        $createdRoles['client']->syncPermissions([]);
    }
}
