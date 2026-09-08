<?php

namespace Database\Seeders;

use App\Enums\ContentStatus;
use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    public function run(): void
    {
        $pages = [
            ['title' => 'About Us',         'slug' => 'about-us',         'template' => 'about'],
            ['title' => 'Our Services',      'slug' => 'services',         'template' => 'services'],
            ['title' => 'Portfolio',         'slug' => 'portfolio',        'template' => 'portfolio'],
            ['title' => 'Contact Us',        'slug' => 'contact',          'template' => 'contact'],
            ['title' => 'Careers',           'slug' => 'careers',          'template' => 'careers'],
            ['title' => 'Privacy Policy',    'slug' => 'privacy-policy',   'template' => 'default'],
            ['title' => 'Terms of Service',  'slug' => 'terms-of-service', 'template' => 'default'],
        ];

        foreach ($pages as $index => $page) {
            Page::create([
                'title' => $page['title'],
                'slug' => $page['slug'],
                'subtitle' => fake()->sentence(),
                'content' => fake()->paragraphs(4, true),
                'featured_image' => null,
                'template' => $page['template'],
                'status' => ContentStatus::Published,
                'sort_order' => $index + 1,
            ]);
        }
    }
}
