<?php

namespace Database\Factories;

use App\Enums\ContentStatus;
use App\Models\Page;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Page>
 */
class PageFactory extends Factory
{
    public function definition(): array
    {
        $pages = [
            ['title' => 'About Us',    'template' => 'about'],
            ['title' => 'Our Services', 'template' => 'services'],
            ['title' => 'Portfolio',   'template' => 'portfolio'],
            ['title' => 'Contact Us',  'template' => 'contact'],
            ['title' => 'Careers',     'template' => 'careers'],
            ['title' => 'Privacy Policy', 'template' => 'default'],
            ['title' => 'Terms of Service', 'template' => 'default'],
        ];

        $page = fake()->unique()->randomElement($pages);
        $slug = Str::slug($page['title']);

        return [
            'title' => $page['title'],
            'slug' => $slug,
            'hero_title' => fake()->sentence(4),
            'hero_banner' => 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?ixlib=rb-4.0.3&auto=format&fit=crop&w=2850&q=80',
            'hero_description' => fake()->paragraph(),
            'content_title' => fake()->sentence(3),
            'content_subtitle' => fake()->sentence(6),
            'content' => fake()->paragraphs(4, true),
            'featured_image' => 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?ixlib=rb-4.0.3&auto=format&fit=crop&w=2850&q=80',
            'template' => $page['template'],
            'status' => ContentStatus::Published,
            'sort_order' => fake()->numberBetween(1, 20),
        ];
    }
}
