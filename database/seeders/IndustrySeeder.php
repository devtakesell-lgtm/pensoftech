<?php

namespace Database\Seeders;

use App\Models\Industry;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class IndustrySeeder extends Seeder
{
    public function run(): void
    {
        $industries = [
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
        ];

        foreach ($industries as $index => $name) {
            Industry::create([
                'name' => $name,
                'slug' => Str::slug($name),
                'short_description' => fake()->sentence(),
                'description' => fake()->paragraph(),
                'icon' => null,
                'image' => null,
                'is_active' => true,
                'sort_order' => $index + 1,
            ]);
        }
    }
}
