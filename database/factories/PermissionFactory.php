<?php

namespace Database\Factories;

use App\Models\Permission;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Permission>
 */
class PermissionFactory extends Factory
{
    public function definition(): array
    {
        $modules = ['clients', 'leads', 'projects', 'quotes', 'blogs', 'jobs', 'users', 'settings'];
        $actions = ['view', 'create', 'edit', 'delete'];

        $module = fake()->randomElement($modules);
        $action = fake()->randomElement($actions);
        $name = ucfirst($action).' '.ucfirst($module);

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'module' => $module,
            'description' => "Allows user to {$action} {$module}.",
        ];
    }
}
