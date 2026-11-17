<?php

namespace Database\Seeders;

use App\Models\Job;
use App\Models\JobApplication;
use Illuminate\Database\Seeder;

class JobApplicationSeeder extends Seeder
{
    public function run(): void
    {
        $jobs = Job::all();

        // Create 3-5 applications for each job listing
        $jobs->each(function (Job $job) {
            $count = rand(3, 5);

            JobApplication::factory($count)->create([
                'job_id' => $job->id,
            ]);
        });
    }
}
