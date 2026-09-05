<?php

namespace Database\Factories;

use App\Enums\ProjectStatus;
use App\Models\Client;
use App\Models\Industry;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Project>
 */
class ProjectFactory extends Factory
{
    public function definition(): array
    {
        $titles = [
            'Corporate Website Redesign',
            'E-Commerce Platform Development',
            'Mobile Banking App',
            'Healthcare Patient Portal',
            'Real Estate Listing Platform',
            'Online Learning Management System',
            'Restaurant Ordering System',
            'Hotel Booking Engine',
            'Logistics Tracking Dashboard',
            'Non-Profit Donation Platform',
            'SaaS CRM System',
            'Inventory Management Tool',
        ];

        // We append a number so we can create more than 12 unique projects.
        // Without this, fake()->unique() runs out of options after 12 calls.
        $title = fake()->randomElement($titles).' #'.fake()->numberBetween(1, 9999);
        $slug = Str::slug($title);
        $startDate = fake()->dateTimeBetween('-2 years', '-3 months');

        return [
            // These are set by ProjectSeeder using existing records.
            // Industry::factory() and Client::factory() are intentionally NOT used here
            // because their slugs are unique and seeded records already exist.
            'client_id' => null,
            'industry_id' => null,
            'title' => $title,
            'slug' => $slug,
            'short_description' => fake()->sentence(),
            'description' => fake()->paragraphs(3, true),
            'project_url' => fake()->url(),
            'featured_image' => 'https://picsum.photos/seed/'.$slug.'/1200/630',
            'start_date' => $startDate,
            'completion_date' => fake()->dateTimeBetween($startDate, 'now'),
            'status' => fake()->randomElement(ProjectStatus::cases()),
            'is_featured' => fake()->boolean(25),
            'sort_order' => fake()->numberBetween(1, 50),
        ];
    }
}
