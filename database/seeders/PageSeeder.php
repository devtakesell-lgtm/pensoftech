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
            $heroTitle = fake()->sentence(4);
            $heroDesc = fake()->paragraph();
            $contentTitle = fake()->sentence(3);
            $contentSubtitle = fake()->sentence();
            $content = fake()->paragraphs(4, true);

            $heroBanner = 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?ixlib=rb-4.0.3&auto=format&fit=crop&w=2850&q=80';
            $featuredImage = null;

            if ($page['slug'] === 'about-us') {
                $heroTitle = 'We Are [PenSoftTech]';
                $heroDesc = 'A collective of engineers, designers, and strategists driven by a singular mission: to build digital products that define the future.';
                $contentTitle = 'Our Journey';
                $contentSubtitle = 'From a small idea to an <span class="text-black italic border-b-4 border-[#4fd1c5]">industry leader.</span>';
                $content = "PenSoftTech was founded on a simple premise: technology should solve problems, not create them. What started as a small team of passionate developers has grown into a full-scale digital agency serving enterprise clients globally.\n\nWe believe in craftsmanship over shortcuts. Every line of code, every pixel designed, and every strategy formulated is done with deep intent and a commitment to excellence.\n\nToday, we are proud to be the engineering backbone for fast-growing startups and established Fortune 500 companies alike, helping them navigate the complexities of the digital age.";
            } elseif ($page['slug'] === 'contact') {
                $heroTitle = "Let's [Talk]";
                $heroDesc = 'Whether you have a specific project in mind or just want to explore possibilities, we\'re ready to listen.';
                $heroBanner = 'https://images.unsplash.com/photo-1451187580459-43490279c0fa?ixlib=rb-4.0.3&auto=format&fit=crop&w=2850&q=80';
                $contentTitle = 'Get in Touch';
                $contentSubtitle = "We'd love to hear from you. Our friendly team is always here to chat.";
                $content = null;
                $featuredImage = null;
            }

            Page::updateOrCreate(
                ['slug' => $page['slug']],
                [
                    'title' => $page['title'],
                    'content_subtitle' => $contentSubtitle,
                    'hero_title' => $heroTitle,
                    'hero_banner' => $heroBanner,
                    'hero_description' => $heroDesc,
                    'content_title' => $contentTitle,
                    'content' => $content,
                    'featured_image' => $featuredImage,
                    'template' => $page['template'],
                    'status' => ContentStatus::Published,
                    'sort_order' => $index + 1,
                ]
            );
        }
    }
}
