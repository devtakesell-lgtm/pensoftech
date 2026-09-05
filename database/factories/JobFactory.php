<?php

namespace Database\Factories;

use App\Enums\EmploymentType;
use App\Enums\JobStatus;
use App\Models\Job;
use App\Models\JobCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Job>
 */
class JobFactory extends Factory
{
    public function definition(): array
    {
        $titles = [
            'Senior Laravel Developer',
            'React Frontend Developer',
            'Full Stack Developer (Next.js + Laravel)',
            'UI/UX Designer',
            'Digital Marketing Specialist',
            'SEO Specialist',
            'Project Manager',
            'Business Development Executive',
            'Content Writer',
            'Junior PHP Developer',
            'Mobile App Developer (Flutter)',
            'DevOps Engineer',
        ];

        $title = fake()->unique()->randomElement($titles);

        return [
            'job_category_id' => JobCategory::factory(),
            'title' => $title,
            'slug' => Str::slug($title),
            'employment_type' => fake()->randomElement(EmploymentType::cases()),
            'location' => fake()->randomElement(['Dhaka, Bangladesh', 'Remote', 'Hybrid – Dhaka', 'Chittagong, Bangladesh']),
            'experience' => fake()->randomElement(['1-2 years', '2-3 years', '3-5 years', '5+ years', 'Fresher']),
            'vacancy' => fake()->numberBetween(1, 5),
            'description' => fake()->paragraphs(3, true),
            'requirements' => fake()->paragraphs(2, true),
            'benefits' => fake()->paragraphs(2, true),
            'deadline' => fake()->dateTimeBetween('now', '+2 months'),
            'status' => JobStatus::Open,
        ];
    }
}
