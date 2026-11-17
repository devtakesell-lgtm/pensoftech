<?php

namespace Database\Factories;

use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Role>
 */
class RoleFactory extends Factory
{
    public function definition(): array
    {
        $name = fake()->unique()->randomElement([
            'administrator',
            'sales-manager',
            'project-manager',
            'developer',
            'designer',
            'content-writer',
            'support-agent',
        ]);

        return [
            'name' => $name,
            'guard_name' => 'web',
            'description' => fake()->sentence(),
            'is_active' => true,
        ];
    }
}
