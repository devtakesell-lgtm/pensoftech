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
            ['name' => 'Web Development', 'icon' => '💻'],
            ['name' => 'Mobile Development', 'icon' => '📱'],
            ['name' => 'UI/UX Design', 'icon' => '🎨'],
            ['name' => 'Digital Marketing', 'icon' => '📈'],
            ['name' => 'Branding & Identity', 'icon' => '✨'],
            ['name' => 'Cloud & DevOps', 'icon' => '☁️'],
            ['name' => 'SEO & Content', 'icon' => '🔍'],
            ['name' => 'E-Commerce Solutions', 'icon' => '🛍️'],
        ];

        foreach ($categories as $index => $cat) {
            ServiceCategory::create([
                'name' => $cat['name'],
                'slug' => Str::slug($cat['name']),
                'short_description' => fake()->sentence(),
                'description' => fake()->paragraph(),
                'icon' => $cat['icon'],
                'image' => null,
                'sort_order' => $index + 1,
                'is_active' => true,
                'is_ecosystem' => in_array($index, [0, 1, 2, 3, 5, 7]), // Set a few as ecosystem
            ]);
        }
    }
}
