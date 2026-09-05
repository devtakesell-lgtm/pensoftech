<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogTag;
use App\Models\User;
use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        $categories = BlogCategory::all();
        $tags = BlogTag::all();
        $users = User::all();

        // Create 15 blog posts
        Blog::factory(15)
            ->make()
            ->each(function (Blog $blog) use ($categories, $tags, $users) {
                // Assign a real category and author
                $blog->blog_category_id = $categories->random()->id;
                $blog->author_id = $users->random()->id;
                $blog->save();

                // Attach 2-4 tags to each post (pivot table: blog_tag)
                $randomTags = $tags->random(rand(2, 4));
                $blog->tags()->attach($randomTags->pluck('id')->toArray());
            });
    }
}
