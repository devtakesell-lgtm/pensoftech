<?php

namespace Database\Factories;

use App\Enums\LeadStatus;
use App\Models\Client;
use App\Models\Lead;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Lead>
 */
class LeadFactory extends Factory
{
    public function definition(): array
    {
        $sources = ['website', 'referral', 'linkedin', 'google_ads', 'facebook_ads', 'cold_email', 'event'];
        $types = ['new_project', 'retainer', 'consultation', 'maintenance'];

        return [
            'client_id' => null,
            'industry_id' => null,
            'assigned_to' => null,
            'currency_id' => null,
            'lead_source' => fake()->randomElement($sources),
            'lead_type' => fake()->randomElement($types),
            'name' => fake()->name(),
            'company_name' => fake()->company(),
            'email' => fake()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'website' => fake()->url(),
            'message' => fake()->paragraph(),
            'budget' => fake()->randomElement([500, 1000, 2500, 5000, 10000, 25000, 50000]),
            'status' => fake()->randomElement(LeadStatus::cases()),
            'utm_source' => fake()->randomElement(['google', 'facebook', null, null]),
            'utm_medium' => fake()->randomElement(['cpc', 'email', 'organic', null, null]),
            'utm_campaign' => null,
            'utm_content' => null,
            'gclid' => null,
            'fbclid' => null,
            'ip_address' => fake()->ipv4(),
        ];
    }
}
