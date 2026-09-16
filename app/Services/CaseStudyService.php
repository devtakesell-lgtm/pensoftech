<?php

namespace App\Services;

use App\Models\CaseStudy;
use Illuminate\Support\Facades\DB;

class CaseStudyService
{
    public function storeCaseStudy(array $validated): CaseStudy
    {
        return DB::transaction(function () use ($validated) {
            $caseStudy = CaseStudy::create($validated);

            $this->syncMetrics($caseStudy, $validated['metrics'] ?? []);
            $this->syncChallenges($caseStudy, $validated['challenges'] ?? []);

            return $caseStudy;
        });
    }

    public function updateCaseStudy(CaseStudy $caseStudy, array $validated): CaseStudy
    {
        return DB::transaction(function () use ($caseStudy, $validated) {
            $caseStudy->update($validated);

            // Delete old relationships and recreate
            $caseStudy->metrics()->delete();
            $this->syncMetrics($caseStudy, $validated['metrics'] ?? []);

            $caseStudy->challenges()->delete();
            $this->syncChallenges($caseStudy, $validated['challenges'] ?? []);

            return $caseStudy;
        });
    }

    private function syncMetrics(CaseStudy $caseStudy, array $metrics): void
    {
        if (empty($metrics)) {
            return;
        }

        $metricsData = [];
        foreach ($metrics as $index => $metric) {
            if (! empty($metric['metric_name'])) {
                $metricsData[] = [
                    'metric_name' => $metric['metric_name'],
                    'metric_value' => $metric['metric_value'] ?? null,
                    'metric_suffix' => $metric['metric_suffix'] ?? null,
                    'sort_order' => $index,
                ];
            }
        }

        if (! empty($metricsData)) {
            $caseStudy->metrics()->createMany($metricsData);
        }
    }

    private function syncChallenges(CaseStudy $caseStudy, array $challenges): void
    {
        if (empty($challenges)) {
            return;
        }

        foreach ($challenges as $challengeData) {
            if (! empty($challengeData['title'])) {
                $challenge = $caseStudy->challenges()->create([
                    'title' => $challengeData['title'],
                    'description' => $challengeData['description'] ?? null,
                ]);

                if (isset($challengeData['solutions']) && is_array($challengeData['solutions'])) {
                    $solutionsData = [];
                    foreach ($challengeData['solutions'] as $solutionData) {
                        if (! empty($solutionData['description'])) {
                            $solutionsData[] = [
                                'description' => $solutionData['description'],
                                'status' => $solutionData['status'] ?? null,
                            ];
                        }
                    }
                    if (! empty($solutionsData)) {
                        $challenge->solutions()->createMany($solutionsData);
                    }
                }
            }
        }
    }
}
