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
                ['name' => 'Custom Website Development', 'icon' => '💻'],
                ['name' => 'React / Next.js Development', 'icon' => '⚛️'],
                ['name' => 'Laravel API Development', 'icon' => '🐘'],
            ],
            'Mobile Development' => [
                ['name' => 'iOS App Development', 'icon' => '🍎'],
                ['name' => 'Android App Development', 'icon' => '🤖'],
                ['name' => 'Flutter App Development', 'icon' => '🦋'],
            ],
            'UI/UX Design' => [
                ['name' => 'UI Wireframing & Prototyping', 'icon' => '📐'],
                ['name' => 'Mobile UI Design', 'icon' => '📱'],
            ],
            'Branding & Identity' => [
                ['name' => 'Brand Identity Design', 'icon' => '✨'],
                ['name' => 'Logo Design', 'icon' => '🎨'],
            ],
            'Digital Marketing' => [
                ['name' => 'Google Ads Management', 'icon' => '📊'],
                ['name' => 'Facebook & Instagram Ads', 'icon' => '📱'],
            ],
            'SEO & Content' => [
                ['name' => 'Search Engine Optimization', 'icon' => '🔍'],
                ['name' => 'Content Strategy & Writing', 'icon' => '✍️'],
            ],
            'E-Commerce Solutions' => [
                ['name' => 'WooCommerce Development', 'icon' => '🛒'],
                ['name' => 'Shopify Store Development', 'icon' => '🛍️'],
            ],
            'Cloud & DevOps' => [
                ['name' => 'Cloud Server Setup & Management', 'icon' => '☁️'],
                ['name' => 'CI/CD Pipeline Setup', 'icon' => '⚙️'],
            ],
        ];

        $sortOrder = 1;

        foreach ($servicesMap as $categoryName => $services) {
            // Find the category we already seeded
            $category = ServiceCategory::where('name', $categoryName)->first();

            foreach ($services as $service) {
                Service::create([
                    'service_category_id' => $category->id,
                    'name' => $service['name'],
                    'slug' => Str::slug($service['name']),
                    'short_description' => fake()->sentence(),
                    'description' => fake()->paragraphs(2, true),
                    'icon' => $service['icon'],
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
