<?php

namespace Database\Factories;

use App\Models\Currency;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Currency>
 */
class CurrencyFactory extends Factory
{
    public function definition(): array
    {
        $currencies = [
            ['name' => 'US Dollar',       'code' => 'USD', 'symbol' => '$',  'exchange_rate' => 1.0000],
            ['name' => 'Euro',            'code' => 'EUR', 'symbol' => '€',  'exchange_rate' => 0.9200],
            ['name' => 'British Pound',   'code' => 'GBP', 'symbol' => '£',  'exchange_rate' => 0.7900],
            ['name' => 'Canadian Dollar', 'code' => 'CAD', 'symbol' => 'C$', 'exchange_rate' => 1.3600],
            ['name' => 'Australian Dollar', 'code' => 'AUD', 'symbol' => 'A$', 'exchange_rate' => 1.5300],
            ['name' => 'Bangladeshi Taka', 'code' => 'BDT', 'symbol' => '৳',  'exchange_rate' => 110.00],
        ];

        $currency = fake()->unique()->randomElement($currencies);

        return [
            'name' => $currency['name'],
            'code' => $currency['code'],
            'symbol' => $currency['symbol'],
            'exchange_rate' => $currency['exchange_rate'],
            'is_default' => false,
            'is_active' => true,
        ];
    }
}
