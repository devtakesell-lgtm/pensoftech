<?php

namespace Database\Factories;

use App\Models\ServiceCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<ServiceCategory>
 */
class ServiceCategoryFactory extends Factory
{
    public function definition(): array
    {
        $name = fake()->unique()->randomElement([
            'Web Development',
            'Mobile Development',
            'UI/UX Design',
            'Digital Marketing',
            'Branding & Identity',
            'Cloud & DevOps',
            'SEO & Content',
            'E-Commerce Solutions',
        ]);

        $slug = Str::slug($name);

        return [
            'name' => $name,
            'slug' => $slug,
            'short_description' => fake()->sentence(),
            'description' => fake()->paragraph(),
            'icon' => 'https://picsum.photos/seed/'.$slug.'-icon/64/64',
            'image' => 'https://picsum.photos/seed/'.$slug.'/1200/630',
            'sort_order' => fake()->numberBetween(1, 10),
            'is_active' => true,
        ];
    }
}
