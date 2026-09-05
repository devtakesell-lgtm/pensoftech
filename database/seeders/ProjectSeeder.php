<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Industry;
use App\Models\Project;
use App\Models\Service;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        // Load data we already seeded so we can link to it
        $clients = Client::all();
        $industries = Industry::all();
        $services = Service::all();

        // Create 20 projects, each linked to an existing client and industry
        Project::factory(20)
            ->make() 
            ->each(function (Project $project) use ($clients, $industries, $services) {
                // Assign a real existing client and industry
                $project->client_id = $clients->random()->id;
                $project->industry_id = $industries->random()->id;
                $project->save();

                $randomServices = $services->random(rand(1, 3));
                $project->services()->attach($randomServices->pluck('id')->toArray());
            });
    }
}
