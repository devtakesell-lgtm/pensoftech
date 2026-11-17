<?php

namespace Database\Seeders;

use App\Models\Industry;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class IndustrySeeder extends Seeder
{
    public function run(): void
    {
        $industries = [
            ['name' => 'Finance & Banking', 'icon' => '🏦', 'desc' => 'Global FinTech: Payments & Security. Scalable platforms for the future of finance.'],
            ['name' => 'Healthcare', 'icon' => '⚕️', 'desc' => 'HealthTech & MedTech. Innovating patient care with robust, compliant platforms.'],
            ['name' => 'E-Commerce', 'icon' => '🛒', 'desc' => 'E-Commerce & Retail. Optimizing digital stores for hyper-growth and conversion.'],
            ['name' => 'Technology', 'icon' => '🏢', 'desc' => 'B2B SaaS Excellence. Transforming businesses with scalable software solutions.'],
            ['name' => 'Logistics', 'icon' => '🚚', 'desc' => 'Logistics & Supply Chain. Streamlining operations and tracking with technology.'],
            ['name' => 'Manufacturing', 'icon' => '⚙️', 'desc' => 'Smart Manufacturing. Industrial IoT and automation platforms.'],
            ['name' => 'Education', 'icon' => '🎓', 'desc' => 'EdTech & Learning. Engaging platforms for modern digital education.'],
            ['name' => 'Real Estate', 'icon' => '🏠', 'desc' => 'PropTech Solutions. Digitizing property management and real estate transactions.'],
            ['name' => 'Hospitality & Travel', 'icon' => '✈️', 'desc' => 'TravelTech. Enhancing booking and management experiences.'],
            ['name' => 'Retail', 'icon' => '🛍️', 'desc' => 'Omnichannel Retail. Connecting physical and digital storefronts.'],
            ['name' => 'Media & Entertainment', 'icon' => '🎬', 'desc' => 'Digital Media. Content delivery and streaming platforms.'],
            ['name' => 'Legal Services', 'icon' => '⚖️', 'desc' => 'LegalTech. Streamlining case management and compliance.']
        ];

        foreach ($industries as $index => $item) {
            Industry::updateOrCreate(
                ['slug' => Str::slug($item['name'])],
                [
                    'name' => $item['name'],
                    'short_description' => $item['desc'],
                    'description' => fake()->paragraph(),
                    'icon' => $item['icon'],
                    'image' => 'https://ui-avatars.com/api/?name=' . urlencode($item['name']) . '&background=random',
                    'is_active' => true,
                    'sort_order' => $index + 1,
                ]
            );
        }
    }
}
