<?php

namespace Database\Factories;

use App\Enums\ContentStatus;
use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Service>
 */
class ServiceFactory extends Factory
{
    public function definition(): array
    {
        $name = fake()->unique()->randomElement([
            'Custom Website Development',
            'React / Next.js Development',
            'Laravel API Development',
            'iOS App Development',
            'Android App Development',
            'UI Wireframing & Prototyping',
            'Brand Identity Design',
            'Logo Design',
            'Google Ads Management',
            'Facebook & Instagram Ads',
            'Search Engine Optimization',
            'E-Commerce Store Setup',
            'WooCommerce Development',
            'Shopify Store Development',
            'Cloud Server Setup & Management',
        ]);

        $slug = Str::slug($name);

        return [
            'service_category_id' => ServiceCategory::factory(),
            'name' => $name,
            'slug' => $slug,
            'short_description' => fake()->sentence(),
            'description' => fake()->paragraphs(2, true),
            'icon' => 'https://picsum.photos/seed/'.$slug.'-icon/64/64',
            'featured_image' => 'https://picsum.photos/seed/'.$slug.'/1200/630',
            'banner_image' => 'https://picsum.photos/seed/'.$slug.'-banner/1920/600',
            'status' => ContentStatus::Published,
            'is_featured' => fake()->boolean(30), // 30% chance of being featured
            'sort_order' => fake()->numberBetween(1, 50),
        ];
    }
}
