<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Define all modules and the actions allowed for each
        $modules = ['clients', 'leads', 'projects', 'quotes', 'blogs', 'jobs', 'users', 'roles', 'settings'];
        $actions = ['view', 'create', 'edit', 'delete'];

        foreach ($modules as $module) {
            foreach ($actions as $action) {
                $name = ucfirst($action).' '.ucfirst($module);

                Permission::create([
                    'name' => $name,
                    'slug' => Str::slug($name),
                    'module' => $module,
                    'description' => "Allows user to {$action} {$module}.",
                ]);
            }
        }
    }
}
