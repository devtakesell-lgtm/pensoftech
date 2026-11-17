<?php

namespace Database\Factories;

use App\Enums\ContentStatus;
use App\Enums\SolutionStatus;
use App\Models\CaseStudy;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<CaseStudy>
 */
class CaseStudyFactory extends Factory
{
    public function definition(): array
    {

        $title = fake()->randomElement([
            'How We Boosted Conversions by 200% for a Healthcare Brand',
            'Rebuilding a Legacy E-Commerce Platform in 90 Days',
            'Scaling a SaaS Product to 10,000 Users with Zero Downtime',
            'Delivering a Full Brand Refresh for a Hospitality Group',
            'How a Mobile App Increased Customer Retention by 40%',
            'From Slow Website to Lightning-Fast: A Performance Case Study',
        ]).' #'.fake()->numberBetween(1, 9999);

        return [
            'project_id' => null,
            'title' => $title,
            'slug' => Str::slug($title),
            'result' => fake()->paragraph(),
            'content' => fake()->paragraphs(5, true),
            'featured_image' => 'https://picsum.photos/seed/'.Str::slug($title).'/1200/630',
            'status' => ContentStatus::Published,
            'published_at' => fake()->dateTimeBetween('-1 year', 'now'),
        ];
    }

    /**
     * Configure the model factory.
     */
    public function configure(): static
    {
        return $this->afterCreating(function (CaseStudy $caseStudy) {
            $challenge = $caseStudy->challenges()->create([
                'title' => fake()->sentence(),
                'description' => fake()->paragraph(),
            ]);

            $challenge->solutions()->create([
                'description' => fake()->paragraph(),
                'status' => fake()->randomElement(SolutionStatus::cases()),
            ]);

            $challenge->solutions()->create([
                'description' => fake()->paragraph(),
                'status' => fake()->randomElement(SolutionStatus::cases()),
            ]);
        });
    }
}
