<?php

namespace Database\Factories;

use App\Models\Industry;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Industry>
 */
class IndustryFactory extends Factory
{
    public function definition(): array
    {
        $name = fake()->unique()->randomElement([
            'E-Commerce',
            'Healthcare',
            'Real Estate',
            'Education',
            'Finance & Banking',
            'Hospitality & Travel',
            'Retail',
            'Technology',
            'Non-Profit',
            'Manufacturing',
            'Media & Entertainment',
            'Legal Services',
        ]);

        $slug = Str::slug($name);

        return [
            'name' => $name,
            'slug' => $slug,
            'short_description' => fake()->sentence(),
            'description' => fake()->paragraph(),
            'icon' => 'https://picsum.photos/seed/'.$slug.'-icon/64/64',
            'image' => 'https://picsum.photos/seed/'.$slug.'/1200/630',
            'is_active' => true,
            'sort_order' => fake()->numberBetween(1, 20),
        ];
    }
}
