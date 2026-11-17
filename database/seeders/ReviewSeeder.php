<?php

namespace Database\Seeders;

use App\Models\Review;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $reviews = [
            [
                'name' => 'Alex Carter',
                'title' => 'Founder, Stackly',
                'content' => 'The team delivered a phenomenal SaaS platform. Their expertise and dedication are unparalleled.',
                'avatar' => 'https://randomuser.me/api/portraits/men/32.jpg',
                'rating' => 5,
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Sarah Chen',
                'title' => 'CTO, Innovate Corp',
                'content' => 'Outstanding results! They transformed our vision into a market-ready product in record time.',
                'avatar' => 'https://randomuser.me/api/portraits/women/44.jpg',
                'rating' => 5,
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Michael Braun',
                'title' => 'CEO, NextGen Solutions',
                'content' => 'Incredible collaboration and top-tier engineering. Highly recommend for any enterprise project.',
                'avatar' => 'https://randomuser.me/api/portraits/men/46.jpg',
                'rating' => 5,
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Jessica Lee',
                'title' => 'Director of Product',
                'content' => "They didn't just build software, they helped refine our entire product strategy. Brilliant minds.",
                'avatar' => 'https://randomuser.me/api/portraits/women/68.jpg',
                'rating' => 5,
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'David Osei',
                'title' => 'Founder, FinTech Pro',
                'content' => 'Flawless execution. Our new cloud architecture is faster and more secure than we ever imagined.',
                'avatar' => 'https://randomuser.me/api/portraits/men/22.jpg',
                'rating' => 5,
                'is_active' => true,
                'sort_order' => 5,
            ],
        ];

        foreach ($reviews as $data) {
            Review::updateOrCreate(
                ['name' => $data['name'], 'title' => $data['title']],
                $data
            );
        }
    }
}
