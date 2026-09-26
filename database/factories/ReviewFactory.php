<?php

namespace Database\Factories;

use App\Models\Review;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'title' => fake()->jobTitle().', '.fake()->company(),
            'content' => fake()->paragraph(),
            'rating' => fake()->numberBetween(4, 5),
            'avatar' => 'https://ui-avatars.com/api/?name='.urlencode(fake()->name()).'&background=random',
            'is_active' => true,
            'sort_order' => fake()->numberBetween(0, 10),
        ];
    }
}
