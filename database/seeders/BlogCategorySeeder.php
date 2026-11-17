<?php

namespace Database\Seeders;

use App\Models\BlogCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BlogCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Web Development',
            'Design Tips',
            'Digital Marketing',
            'Case Studies',
            'Industry News',
            'Company Updates',
            'Technology Trends',
        ];

        foreach ($categories as $name) {
            BlogCategory::create([
                'name' => $name,
                'slug' => Str::slug($name),
                'description' => fake()->sentence(),
                'is_active' => true,
            ]);
        }
    }
}
