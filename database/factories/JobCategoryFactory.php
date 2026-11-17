<?php

namespace Database\Factories;

use App\Models\JobCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<JobCategory>
 */
class JobCategoryFactory extends Factory
{
    public function definition(): array
    {
        $name = fake()->unique()->randomElement([
            'Engineering',
            'Design',
            'Marketing',
            'Sales',
            'Project Management',
            'Content & Copywriting',
            'Customer Support',
            'Finance & Accounting',
            'Human Resources',
        ]);

        return [
            'name' => $name,
            'slug' => Str::slug($name),
        ];
    }
}
