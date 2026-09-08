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
        // Get roles created in RoleSeeder
        $adminRole = Role::where('name', 'administrator')->first();
        $salesRole = Role::where('name', 'sales-manager')->first();
        $pmRole = Role::where('name', 'project-manager')->first();
        $clientRole = Role::where('name', 'client')->first();

        // 1. Create a fixed admin account you can always log in with
        $admin = User::create([
            'role_id' => $adminRole?->id,
            'name' => 'Admin User',
            'email' => 'admin@pensoftech.com',
            'phone' => '+880 1700-000000',
            'is_active' => true,
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
        ]);
        if ($adminRole) {
            $admin->assignRole($adminRole);
        }

        // 2. Create a sales manager
        $sales = User::create([
            'role_id' => $salesRole?->id,
            'name' => 'Manchur Iqbal',
            'email' => 'manchur@pensoftech.com',
            'phone' => '+880 1700-000001',
            'is_active' => true,
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
        ]);
        if ($salesRole) {
            $sales->assignRole($salesRole);
        }

        // 3. Create a project manager
        $pm = User::create([
            'role_id' => $pmRole?->id,
            'name' => 'Shihan Rahman',
            'email' => 'shihan@pensoftech.com',
            'phone' => '+880 1700-000002',
            'is_active' => true,
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
        ]);
        if ($pmRole) {
            $pm->assignRole($pmRole);
        }

        // 4. Create a client user
        $client = User::create([
            'role_id' => $clientRole?->id,
            'name' => 'Rakib Hasan',
            'email' => 'rakib@pensoftech.com',
            'phone' => '+880 1700-000003',
            'is_active' => true,
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
        ]);
        if ($clientRole) {
            $client->assignRole($clientRole);
        }

        // 5. Create 5 more team members using the factory
        $teamMembers = User::factory(5)->create([
            'role_id' => $adminRole?->id,
        ]);
        foreach ($teamMembers as $member) {
            if ($adminRole) {
                $member->assignRole($adminRole);
            }
        }
    }
}
