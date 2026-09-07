<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Create the core roles your agency needs
        $roles = [
            ['name' => 'Administrator',    'slug' => 'administrator',     'description' => 'Full access to everything.'],
            ['name' => 'Sales Manager',    'slug' => 'sales-manager',     'description' => 'Manages leads and quotes.'],
            ['name' => 'Project Manager',  'slug' => 'project-manager',   'description' => 'Manages projects and clients.'],
            ['name' => 'Developer',        'slug' => 'developer',         'description' => 'Works on development tasks.'],
            ['name' => 'Designer',         'slug' => 'designer',          'description' => 'Works on design tasks.'],
            ['name' => 'Content Writer',   'slug' => 'content-writer',    'description' => 'Writes blog posts and content.'],
            ['name' => 'Client',           'slug' => 'client',            'description' => 'Client account for portal and project tracking.'],
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(['slug' => $role['slug']], array_merge($role, ['is_active' => true]));
        }
    }
}
