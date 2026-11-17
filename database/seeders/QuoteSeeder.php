<?php

namespace Database\Seeders;

use App\Models\Currency;
use App\Models\Lead;
use App\Models\Quote;
use App\Models\User;
use Illuminate\Database\Seeder;

class QuoteSeeder extends Seeder
{
    public function run(): void
    {
        $leads = Lead::all();
        $currencies = Currency::all();
        $users = User::all();

        // Create one quote for each of the first 15 leads
        $leads->take(15)->each(function (Lead $lead) use ($currencies, $users) {
            Quote::factory()->create([
                'lead_id' => $lead->id,
                'currency_id' => $currencies->random()->id,
                'created_by' => $users->random()->id,
            ]);
        });
    }
}
