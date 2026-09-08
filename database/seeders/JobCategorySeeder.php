<?php

namespace Database\Seeders;

use App\Models\JobCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class JobCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Engineering',
            'Design',
            'Marketing',
            'Sales',
            'Project Management',
            'Content & Copywriting',
            'Customer Support',
            'Finance & Accounting',
        ];

        foreach ($categories as $name) {
            JobCategory::create([
                'name' => $name,
                'slug' => Str::slug($name),
            ]);
        }
    }
}
