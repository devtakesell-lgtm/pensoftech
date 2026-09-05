<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Get roles we created in RoleSeeder
        $adminRole = Role::where('slug', 'administrator')->first();
        $salesRole = Role::where('slug', 'sales-manager')->first();
        $pmRole = Role::where('slug', 'project-manager')->first();

        // 1. Create a fixed admin account you can always log in with
        User::create([
            'role_id' => $adminRole?->id,
            'name' => 'Admin User',
            'email' => 'admin@pensoftech.com',
            'phone' => '+880 1700-000001',
            'is_active' => true,
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
        ]);

        // 2. Create a sales manager
        User::create([
            'role_id' => $salesRole?->id,
            'name' => 'Sarah Ahmed',
            'email' => 'sarah@pensoftech.com',
            'phone' => '+880 1700-000002',
            'is_active' => true,
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
        ]);

        // 3. Create a project manager
        User::create([
            'role_id' => $pmRole?->id,
            'name' => 'Rafiq Hassan',
            'email' => 'rafiq@pensoftech.com',
            'phone' => '+880 1700-000003',
            'is_active' => true,
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
        ]);

        // 4. Create 5 more random team members using the factory
        User::factory(5)->create([
            'role_id' => $adminRole?->id,
        ]);
    }
}
