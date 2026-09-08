<?php

namespace Database\Factories;

use App\Models\Quote;
use App\Models\QuoteService;
use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<QuoteService>
 */
class QuoteServiceFactory extends Factory
{
    public function definition(): array
    {
        $quantity = fake()->numberBetween(1, 5);
        $unitPrice = fake()->randomElement([500, 800, 1000, 1500, 2000, 3000, 5000]);

        return [
            'quote_id' => Quote::factory(),
            'service_id' => Service::factory(),
            'quantity' => $quantity,
            'unit_price' => $unitPrice,
            'total_price' => $quantity * $unitPrice,
            'description' => fake()->sentence(),
        ];
    }
}
