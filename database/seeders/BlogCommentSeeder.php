<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\BlogComment;
use Illuminate\Database\Seeder;

class BlogCommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $blogs = Blog::take(5)->get();

        if ($blogs->isEmpty()) {
            $blogs = Blog::factory(3)->create();
        }

        foreach ($blogs as $blog) {
            // Create some top-level comments
            $comments = BlogComment::factory(5)->create([
                'blog_id' => $blog->id,
            ]);

            // Create some nested replies
            foreach ($comments->random(2) as $comment) {
                BlogComment::factory(2)->create([
                    'blog_id' => $blog->id,
                    'parent_id' => $comment->id,
                ]);
            }
        }
    }
}
