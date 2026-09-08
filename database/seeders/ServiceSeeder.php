<?php

namespace Database\Seeders;

use App\Enums\ContentStatus;
use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        // Map each service to its correct category
        $servicesMap = [
            'Web Development' => [
                'Custom Website Development',
                'React / Next.js Development',
                'Laravel API Development',
            ],
            'Mobile Development' => [
                'iOS App Development',
                'Android App Development',
                'Flutter App Development',
            ],
            'UI/UX Design' => [
                'UI Wireframing & Prototyping',
                'Mobile UI Design',
            ],
            'Branding & Identity' => [
                'Brand Identity Design',
                'Logo Design',
            ],
            'Digital Marketing' => [
                'Google Ads Management',
                'Facebook & Instagram Ads',
            ],
            'SEO & Content' => [
                'Search Engine Optimization',
                'Content Strategy & Writing',
            ],
            'E-Commerce Solutions' => [
                'WooCommerce Development',
                'Shopify Store Development',
            ],
            'Cloud & DevOps' => [
                'Cloud Server Setup & Management',
                'CI/CD Pipeline Setup',
            ],
        ];

        $sortOrder = 1;

        foreach ($servicesMap as $categoryName => $services) {
            // Find the category we already seeded
            $category = ServiceCategory::where('name', $categoryName)->first();

            foreach ($services as $name) {
                Service::create([
                    'service_category_id' => $category->id,
                    'name' => $name,
                    'slug' => Str::slug($name),
                    'short_description' => fake()->sentence(),
                    'description' => fake()->paragraphs(2, true),
                    'icon' => null,
                    'featured_image' => null,
                    'banner_image' => null,
                    'status' => ContentStatus::Published,
                    'is_featured' => $sortOrder <= 4, // first 4 are featured
                    'sort_order' => $sortOrder++,
                ]);
            }
        }
    }
}
