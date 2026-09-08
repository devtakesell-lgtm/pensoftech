<?php

namespace Database\Factories;

use App\Models\Permission;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Permission>
 */
class PermissionFactory extends Factory
{
    public function definition(): array
    {
        $modules = ['clients', 'leads', 'projects', 'quotes', 'blogs', 'jobs', 'users', 'roles', 'settings'];
        $actions = ['view', 'create', 'edit', 'delete'];

        $module = fake()->randomElement($modules);
        $action = fake()->randomElement($actions);
        $name = "{$action}-{$module}";

        return [
            'name' => $name,
            'guard_name' => 'web',
            'module' => $module,
            'description' => "Allows user to {$action} {$module}.",
        ];
    }
}
