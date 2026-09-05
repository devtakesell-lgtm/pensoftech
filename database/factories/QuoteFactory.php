<?php

namespace Database\Factories;

use App\Enums\QuoteStatus;
use App\Models\Quote;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Quote>
 */
class QuoteFactory extends Factory
{
    public function definition(): array
    {
        $budgetMin = fake()->randomElement([1000, 2500, 5000, 10000, 20000]);
        $budgetMax = $budgetMin * fake()->randomFloat(1, 1.2, 2.0);

        return [
            'lead_id' => null,
            'currency_id' => null,
            'quote_number' => 'QT-'.strtoupper(fake()->bothify('####??')),
            'title' => fake()->randomElement([
                'Website Redesign Proposal',
                'Mobile App Development Quote',
                'Digital Marketing Retainer Proposal',
                'E-Commerce Platform Quote',
                'Brand Identity Package',
                'SEO & Content Strategy Proposal',
            ]),
            'description' => fake()->paragraph(),
            'budget_min' => $budgetMin,
            'budget_max' => round($budgetMax, 2),
            'status' => fake()->randomElement(QuoteStatus::cases()),
            'valid_until' => fake()->dateTimeBetween('now', '+3 months'),
            'created_by' => null, 
        ];
    }
}
