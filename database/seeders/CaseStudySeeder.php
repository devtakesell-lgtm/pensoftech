<?php

namespace Database\Seeders;

use App\Models\CaseStudy;
use App\Models\Project;
use Illuminate\Database\Seeder;

class CaseStudySeeder extends Seeder
{
    public function run(): void
    {
        // Only create case studies for completed projects
        $projects = Project::all();

        // Create one case study for each of the first 8 projects
        $projects->take(8)->each(function (Project $project) {
            CaseStudy::factory()->create([
                'project_id' => $project->id,
                // No client_id — use $caseStudy->project->client to access the client
            ]);
        });
    }
}
