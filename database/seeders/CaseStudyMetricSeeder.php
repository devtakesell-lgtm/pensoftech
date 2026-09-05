<?php

namespace Database\Seeders;

use App\Models\CaseStudy;
use App\Models\CaseStudyMetric;
use Illuminate\Database\Seeder;

class CaseStudyMetricSeeder extends Seeder
{
    public function run(): void
    {
        // Load all case studies and add 2-4 metrics to each one
        CaseStudy::all()->each(function (CaseStudy $caseStudy) {
            // Pick 2-4 random metrics for this case study
            $metricData = [
                ['metric_name' => 'Conversion Rate Increase', 'metric_value' => rand(20, 200), 'metric_suffix' => '%'],
                ['metric_name' => 'Page Load Time Reduction',  'metric_value' => rand(30, 70),  'metric_suffix' => '%'],
                ['metric_name' => 'Monthly Active Users',       'metric_value' => rand(500, 10000), 'metric_suffix' => '+'],
                ['metric_name' => 'Revenue Growth',             'metric_value' => rand(15, 150), 'metric_suffix' => '%'],
                ['metric_name' => 'Customer Satisfaction Score', 'metric_value' => rand(90, 98), 'metric_suffix' => '%'],
            ];

            // Shuffle and take 3 random metrics
            shuffle($metricData);
            $selected = array_slice($metricData, 0, 3);

            foreach ($selected as $index => $data) {
                CaseStudyMetric::create([
                    'case_study_id' => $caseStudy->id,
                    'metric_name' => $data['metric_name'],
                    'metric_value' => (string) $data['metric_value'],
                    'metric_suffix' => $data['metric_suffix'],
                    'sort_order' => $index + 1,
                ]);
            }
        });
    }
}
