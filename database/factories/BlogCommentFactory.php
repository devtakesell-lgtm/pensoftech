<?php

namespace Database\Factories;

use App\Models\BlogComment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<BlogComment>
 */
class BlogCommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'blog_id' => \App\Models\Blog::factory(),
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'content' => fake()->paragraph(),
            'status' => fake()->randomElement(\App\Enums\CommentStatus::cases()),
        ];
    }
}
