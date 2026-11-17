<?php

namespace App\Http\Controllers\Frontend;

use App\Enums\CommentStatus;
use App\Enums\ContentStatus;
use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogComment;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::with(['category', 'author'])
            ->where('status', ContentStatus::Published)
            ->orderBy('published_at', 'desc')
            ->paginate(9);

        return view('frontend.pages.blogs.index')->with([
            'blogs' => $blogs,
        ]);
    }

    public function show($slug)
    {
        $blog = Blog::with([
            'category',
            'author',
            'seo',
            'tags',
            'comments' => function ($q) {
                $q->whereNull('parent_id')->approved()->with(['replies' => function ($q2) {
                    $q2->approved();
                }]);
            },
        ])
            ->where('slug', $slug)
            ->where('status', ContentStatus::Published)
            ->firstOrFail();

        // Increment view count
        $blog->increment('views');

        $relatedBlogs = Blog::with(['category', 'author'])
            ->where('blog_category_id', $blog->blog_category_id)
            ->where('id', '!=', $blog->id)
            ->where('status', ContentStatus::Published)
            ->orderBy('published_at', 'desc')
            ->take(3)
            ->get();

        return view('frontend.pages.blogs.single')->with([
            'blog' => $blog,
            'relatedBlogs' => $relatedBlogs,
        ]);
    }

    public function storeComment(Request $request, Blog $blog)
    {
        $validated = $request->validate([
            'name' => auth()->check() ? 'nullable|string|max:255' : 'required|string|max:255',
            'email' => auth()->check() ? 'nullable|email|max:255' : 'required|email|max:255',
            'content' => 'required|string|max:1000',
            'parent_id' => 'nullable|exists:blog_comments,id',
        ]);

        $validated['blog_id'] = $blog->id;
        $validated['status'] = CommentStatus::Pending;

        if (auth()->check()) {
            $validated['user_id'] = auth()->id();
            $validated['name'] = auth()->user()->name;
            $validated['email'] = auth()->user()->email;
            $validated['status'] = CommentStatus::Approved; // Auto-approve logged in users, or keep pending based on requirements
        }

        BlogComment::create($validated);

        return back()->with('success', 'Your comment has been submitted and is pending approval.');
    }
}
