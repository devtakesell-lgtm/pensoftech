<?php

namespace Database\Factories;

use App\Enums\JobApplicationStatus;
use App\Models\Job;
use App\Models\JobApplication;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<JobApplication>
 */
class JobApplicationFactory extends Factory
{
    public function definition(): array
    {
        return [
            'job_id' => Job::factory(),
            'name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'address' => fake()->address(),
            'cv_file' => 'resumes/'.fake()->slug().'.pdf',
            'cover_letter' => fake()->paragraph(),
            'linkedin_url' => 'https://linkedin.com/in/'.fake()->userName(),
            'portfolio_url' => fake()->boolean(40) ? fake()->url() : null,
            'github_url' => fake()->boolean(50) ? 'https://github.com/'.fake()->userName() : null,
            'status' => fake()->randomElement(JobApplicationStatus::cases()),
            'notes' => fake()->boolean(30) ? fake()->sentence() : null,
        ];
    }
}
