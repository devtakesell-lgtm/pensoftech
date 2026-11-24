<?php

namespace Database\Seeders;

use App\Models\Instructor;
use App\Models\User;
use Illuminate\Database\Seeder;

class InstructorSeeder extends Seeder
{
    public function run(): void
    {
        $adminUser = User::first();

        $instructors = [
            [
                'name' => 'Engr. Tanvir Ahmed',
                'designation' => 'Lead Software Engineer @ PenSoftTech',
                'bio' => 'Senior full-stack engineer with 7+ years of industry experience specializing in Laravel, cloud architectures, and scalable microservices.',
                'skills' => ['Laravel', 'PHP 8', 'MySQL', 'Docker', 'REST API', 'Vue.js'],
                'social_links' => [
                    'linkedin' => 'https://linkedin.com',
                    'github' => 'https://github.com',
                ],
                'is_active' => true,
            ],
            [
                'name' => 'Farhana Yasmin',
                'designation' => 'Lead UI/UX Designer @ PenSoftTech',
                'bio' => 'Product designer with 5+ years of experience designing enterprise software, design systems, and mobile applications in Figma.',
                'skills' => ['Figma', 'Design Systems', 'User Research', 'Prototyping', 'Tailwind CSS'],
                'social_links' => [
                    'linkedin' => 'https://linkedin.com',
                    'behance' => 'https://behance.net',
                ],
                'is_active' => true,
            ],
        ];

        foreach ($instructors as $instructor) {
            Instructor::firstOrCreate(
                ['name' => $instructor['name']],
                array_merge($instructor, ['user_id' => $adminUser?->id])
            );
        }
    }
}
