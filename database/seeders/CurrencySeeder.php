<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    public function run(): void
    {
        // Seed real currencies — we use fixed data here, not random factory data,
        // because currency codes must be exact and unique
        $currencies = [
            ['name' => 'US Dollar',         'code' => 'USD', 'symbol' => '$',  'exchange_rate' => 1.0000, 'is_default' => true],
            ['name' => 'Euro',              'code' => 'EUR', 'symbol' => '€',  'exchange_rate' => 0.9200, 'is_default' => false],
            ['name' => 'British Pound',     'code' => 'GBP', 'symbol' => '£',  'exchange_rate' => 0.7900, 'is_default' => false],
            ['name' => 'Canadian Dollar',   'code' => 'CAD', 'symbol' => 'C$', 'exchange_rate' => 1.3600, 'is_default' => false],
            ['name' => 'Bangladeshi Taka',  'code' => 'BDT', 'symbol' => '৳',  'exchange_rate' => 110.00, 'is_default' => false],
        ];

        foreach ($currencies as $currency) {
            Currency::create(array_merge($currency, ['is_active' => true]));
        }
    }
}
