<?php

namespace Database\Seeders;

use App\Models\Currency;
use App\Models\Industry;
use App\Models\Lead;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Seeder;

class LeadSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        $industries = Industry::all();
        $currencies = Currency::all();
        $services = Service::all();

        // Create 30 leads
        Lead::factory(30)
            ->make()
            ->each(function (Lead $lead) use ($users, $industries, $currencies, $services) {
                // Assign real industry and currency
                $lead->industry_id = $industries->random()->id;
                $lead->currency_id = $currencies->random()->id;
                $lead->assigned_to = $users->random()->id;
                $lead->save();

                // Attach 1 to 3 services the lead is interested in
                $randomServices = $services->random(rand(1, 3));
                $lead->services()->attach($randomServices->pluck('id')->toArray());
            });
    }
}
