<?php

namespace Database\Seeders;

use App\Models\BlogTag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BlogTagSeeder extends Seeder
{
    public function run(): void
    {
        $tags = [
            'Laravel', 'React', 'Next.js', 'SEO', 'UI Design',
            'Branding', 'E-Commerce', 'Performance', 'Mobile', 'API',
            'Cloud', 'Startup', 'Agency Life', 'WordPress', 'Shopify',
        ];

        foreach ($tags as $name) {
            BlogTag::create([
                'name' => $name,
                'slug' => Str::slug($name),
            ]);
        }
    }
}
