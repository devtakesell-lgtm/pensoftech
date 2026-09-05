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
            'subtitle' => fake()->sentence(),
            'content' => fake()->paragraphs(4, true),
            'featured_image' => 'https://picsum.photos/seed/'.$slug.'/1200/630',
            'template' => $page['template'],
            'status' => ContentStatus::Published,
            'sort_order' => fake()->numberBetween(1, 20),
        ];
    }
}
