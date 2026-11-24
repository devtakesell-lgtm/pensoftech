<?php

namespace Database\Seeders;

use App\Models\CourseCategory;
use Illuminate\Database\Seeder;

class CourseCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Web Development',
                'slug' => 'web-development',
                'icon' => 'bi-code-slash',
                'description' => 'Learn full-stack modern web development with Laravel, Vue, React, and Tailwind CSS.',
                'order' => 1,
            ],
            [
                'name' => 'Mobile App Development',
                'slug' => 'mobile-app-development',
                'icon' => 'bi-phone',
                'description' => 'Build cross-platform iOS and Android applications with Flutter and React Native.',
                'order' => 2,
            ],
            [
                'name' => 'UI/UX & Product Design',
                'slug' => 'ui-ux-design',
                'icon' => 'bi-palette',
                'description' => 'Master Figma, design systems, wireframing, and user-centered design processes.',
                'order' => 3,
            ],
            [
                'name' => 'Cyber Security & DevOps',
                'slug' => 'devops-security',
                'icon' => 'bi-shield-check',
                'description' => 'Master Linux server administration, Docker, CI/CD pipelines, and application security.',
                'order' => 4,
            ],
        ];

        foreach ($categories as $cat) {
            CourseCategory::firstOrCreate(
                ['slug' => $cat['slug']],
                array_merge($cat, ['is_active' => true])
            );
        }
    }
}
