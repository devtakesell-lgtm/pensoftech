<?php

namespace Database\Seeders;

use App\Models\Quote;
use App\Models\QuoteService;
use App\Models\Service;
use Illuminate\Database\Seeder;

class QuoteServiceSeeder extends Seeder
{
    public function run(): void
    {
        $quotes = Quote::all();
        $services = Service::all();

        // Add 1 to 3 line items to each quote
        $quotes->each(function (Quote $quote) use ($services) {
            $count = rand(1, 3);

            // Pick random services without duplicates for this quote
            $selectedServices = $services->random($count);

            foreach ($selectedServices as $service) {
                $quantity = rand(1, 5);
                $unitPrice = fake()->randomElement([500, 800, 1000, 1500, 2000, 3000]);

                QuoteService::create([
                    'quote_id' => $quote->id,
                    'service_id' => $service->id,
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'total_price' => $quantity * $unitPrice,
                    'description' => fake()->sentence(),
                ]);
            }
        });
    }
}
