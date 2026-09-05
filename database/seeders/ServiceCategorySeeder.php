<?php

namespace Database\Seeders;

use App\Models\ServiceCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ServiceCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Web Development',
            'Mobile Development',
            'UI/UX Design',
            'Digital Marketing',
            'Branding & Identity',
            'Cloud & DevOps',
            'SEO & Content',
            'E-Commerce Solutions',
        ];

        foreach ($categories as $index => $name) {
            ServiceCategory::create([
                'name' => $name,
                'slug' => Str::slug($name),
                'short_description' => fake()->sentence(),
                'description' => fake()->paragraph(),
                'icon' => null,
                'image' => null,
                'sort_order' => $index + 1,
                'is_active' => true,
            ]);
        }
    }
}
