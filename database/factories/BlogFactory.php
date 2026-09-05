<?php

namespace Database\Factories;

use App\Enums\ContentStatus;
use App\Models\Blog;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Blog>
 */
class BlogFactory extends Factory
{
    public function definition(): array
    {
        $titles = [
            '10 Reasons Your Website Is Losing Customers (And How to Fix It)',
            'How We Build Laravel APIs That Scale to Millions of Requests',
            'The Complete Guide to Choosing a Digital Agency in 2024',
            'React vs Vue: Which Frontend Framework Is Right for Your Project?',
            'Why Your Brand Needs a Design System — Not Just a Style Guide',
            'How to Measure the ROI of Your Digital Marketing Campaign',
            'From Idea to Launch: Our 8-Step Web Development Process',
            'The Biggest Mistakes Businesses Make When Redesigning Their Website',
            'E-Commerce SEO: The 2024 Checklist You Actually Need',
            'How We Delivered a Complex Platform in Half the Expected Time',
        ];

       
        $title = fake()->randomElement($titles).' #'.fake()->numberBetween(1, 9999);
        $publishedAt = fake()->dateTimeBetween('-1 year', 'now');

        return [
            'blog_category_id' => null,
            'author_id' => null, 
            'title' => $title,
            'slug' => Str::slug($title),
            'excerpt' => fake()->sentences(2, true),
            'content' => fake()->paragraphs(8, true),
            'featured_image' => 'https://picsum.photos/seed/'.Str::slug($title).'/1200/630',
            'status' => ContentStatus::Published,
            'published_at' => $publishedAt,
            'reading_time' => fake()->numberBetween(3, 15), 
            'views' => fake()->numberBetween(0, 5000),
        ];
    }
}
