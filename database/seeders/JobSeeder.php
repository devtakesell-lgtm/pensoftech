<?php

namespace Database\Seeders;

use App\Enums\EmploymentType;
use App\Enums\JobStatus;
use App\Models\Job;
use App\Models\JobCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class JobSeeder extends Seeder
{
    public function run(): void
    {
        $categories = JobCategory::all();

        // Define a fixed list of open positions
        $jobs = [
            ['title' => 'Senior Laravel Developer',            'category' => 'Engineering',    'type' => EmploymentType::FullTime],
            ['title' => 'React Frontend Developer',            'category' => 'Engineering',    'type' => EmploymentType::FullTime],
            ['title' => 'Full Stack Developer (Next.js)',      'category' => 'Engineering',    'type' => EmploymentType::FullTime],
            ['title' => 'UI/UX Designer',                     'category' => 'Design',         'type' => EmploymentType::FullTime],
            ['title' => 'Junior Graphic Designer',            'category' => 'Design',         'type' => EmploymentType::FullTime],
            ['title' => 'Digital Marketing Specialist',       'category' => 'Marketing',      'type' => EmploymentType::FullTime],
            ['title' => 'SEO Specialist',                     'category' => 'Marketing',      'type' => EmploymentType::Contract],
            ['title' => 'Business Development Executive',     'category' => 'Sales',          'type' => EmploymentType::FullTime],
            ['title' => 'Project Manager',                    'category' => 'Project Management', 'type' => EmploymentType::FullTime],
            ['title' => 'Content Writer',                     'category' => 'Content & Copywriting', 'type' => EmploymentType::PartTime],
        ];

        foreach ($jobs as $job) {
            $category = $categories->firstWhere('name', $job['category']);

            Job::create([
                'job_category_id' => $category?->id,
                'title' => $job['title'],
                'slug' => Str::slug($job['title']),
                'employment_type' => $job['type'],
                'location' => 'Dhaka, Bangladesh',
                'experience' => fake()->randomElement(['1-2 years', '2-3 years', '3-5 years']),
                'vacancy' => rand(1, 3),
                'description' => fake()->paragraphs(3, true),
                'requirements' => fake()->paragraphs(2, true),
                'benefits' => fake()->paragraphs(2, true),
                'deadline' => now()->addMonths(2),
                'status' => JobStatus::Open,
            ]);
        }
    }
}
