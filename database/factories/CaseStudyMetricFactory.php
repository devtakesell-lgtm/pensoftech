<?php

namespace Database\Factories;

use App\Models\CaseStudy;
use App\Models\CaseStudyMetric;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CaseStudyMetric>
 */
class CaseStudyMetricFactory extends Factory
{
    public function definition(): array
    {
        // These look like real results you'd showcase in a portfolio
        $metrics = [
            ['name' => 'Conversion Rate Increase', 'value' => fake()->numberBetween(20, 300), 'suffix' => '%'],
            ['name' => 'Page Load Time Reduction',  'value' => fake()->numberBetween(30, 80),  'suffix' => '%'],
            ['name' => 'Monthly Active Users',       'value' => fake()->numberBetween(500, 50000), 'suffix' => '+'],
            ['name' => 'Revenue Growth',             'value' => fake()->numberBetween(15, 200), 'suffix' => '%'],
            ['name' => 'Projects Delivered',         'value' => fake()->numberBetween(5, 50),   'suffix' => null],
            ['name' => 'Customer Satisfaction',      'value' => fake()->numberBetween(90, 99),   'suffix' => '%'],
        ];

        $metric = fake()->randomElement($metrics);

        return [
            'case_study_id' => CaseStudy::factory(),
            'metric_name' => $metric['name'],
            'metric_value' => (string) $metric['value'],
            'metric_suffix' => $metric['suffix'],
            'sort_order' => fake()->numberBetween(1, 10),
        ];
    }
}
