<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\Page;
use App\Models\Project;
use App\Models\Service;
use Illuminate\Database\Seeder;

class SeoMetaSeeder extends Seeder
{
    public function run(): void
    {
        // Add SEO meta to all published projects
        Project::all()->each(function (Project $project) {
            $project->seo()->create([
                'meta_title' => $project->title.' | Pensoftech Portfolio',
                'meta_description' => $project->short_description ?? fake()->sentence(),
                'meta_keywords' => implode(', ', fake()->words(5)),
                'robots' => 'index, follow',
                'og_title' => $project->title,
                'og_description' => $project->short_description ?? fake()->sentence(),
            ]);
        });

        // Add SEO meta to all published services
        Service::all()->each(function (Service $service) {
            $service->seo()->create([
                'meta_title' => $service->name.' | Pensoftech',
                'meta_description' => $service->short_description ?? fake()->sentence(),
                'meta_keywords' => implode(', ', fake()->words(5)),
                'robots' => 'index, follow',
                'og_title' => $service->name,
                'og_description' => $service->short_description ?? fake()->sentence(),
            ]);
        });

        // Add SEO meta to all published blog posts
        Blog::all()->each(function (Blog $blog) {
            $blog->seo()->create([
                'meta_title' => $blog->title.' | Pensoftech Blog',
                'meta_description' => $blog->excerpt ?? fake()->sentence(),
                'meta_keywords' => implode(', ', fake()->words(5)),
                'robots' => 'index, follow',
                'og_title' => $blog->title,
                'og_description' => $blog->excerpt ?? fake()->sentence(),
            ]);
        });

        // Add SEO meta to all pages
        Page::all()->each(function (Page $page) {
            $page->seo()->create([
                'meta_title' => $page->title.' | Pensoftech',
                'meta_description' => $page->subtitle ?? fake()->sentence(),
                'meta_keywords' => implode(', ', fake()->words(5)),
                'robots' => 'index, follow',
                'og_title' => $page->title,
                'og_description' => $page->subtitle ?? fake()->sentence(),
            ]);
        });
    }
}
