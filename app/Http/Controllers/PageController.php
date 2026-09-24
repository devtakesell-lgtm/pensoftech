<?php

namespace App\Http\Controllers;

use App\Enums\ContentStatus;
use App\Models\Page;
use App\Models\Service;
use App\Models\ServiceCategory;

class PageController extends Controller
{
    public function about()
    {
        return view('frontend.pages.about');
    }

    public function contact()
    {
        return view('frontend.pages.contact');
    }

    public function digitalMarketing()
    {
        return view('frontend.pages.digital-marketing');
    }

    public function softwareDevelopment()
    {
        return view('frontend.pages.software-development');
    }

    public function services()
    {
        $page = Page::with('seo')->where('slug', 'services')->first();
        $categories = ServiceCategory::with(['services' => function ($q) {
            $q->where('status', ContentStatus::Published)->orderBy('sort_order');
        }])->where('is_active', true)->orderBy('sort_order')->get();

        return view('frontend.pages.services', compact('page', 'categories'));
    }

    public function serviceCategory($slug)
    {
        $category = ServiceCategory::with(['services' => function ($q) {
            $q->where('status', ContentStatus::Published)->orderBy('sort_order');
        }])->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        return view('frontend.pages.service-category', compact('category'));
    }

    public function singleService($category_slug, $service_slug)
    {
        $category = ServiceCategory::where('slug', $category_slug)
            ->where('is_active', true)
            ->firstOrFail();

        $service = Service::with('seo')
            ->where('service_category_id', $category->id)
            ->where('slug', $service_slug)
            ->where('status', ContentStatus::Published)
            ->firstOrFail();

        $relatedServices = Service::where('service_category_id', $category->id)
            ->where('id', '!=', $service->id)
            ->where('status', ContentStatus::Published)
            ->orderBy('sort_order')
            ->take(6)
            ->get();

        return view('frontend.pages.service-single')->with([
            'category' => $category,
            'service' => $service,
            'relatedServices' => $relatedServices,
        ]);
    }

    public function blogs()
    {
        $blogs = \App\Models\Blog::with(['category', 'author'])
            ->where('status', ContentStatus::Published)
            ->orderBy('published_at', 'desc')
            ->paginate(9);

        return view('frontend.pages.blogs.index', compact('blogs'));
    }

    public function singleBlog($slug)
    {
        $blog = \App\Models\Blog::with([
            'category', 
            'author', 
            'seo', 
            'tags',
            'comments' => function ($q) {
                $q->whereNull('parent_id')->approved()->with(['replies' => function ($q2) {
                    $q2->approved();
                }]);
            }
        ])
            ->where('slug', $slug)
            ->where('status', ContentStatus::Published)
            ->firstOrFail();

        // Increment view count
        $blog->increment('views');

        $relatedBlogs = \App\Models\Blog::with(['category', 'author'])
            ->where('blog_category_id', $blog->blog_category_id)
            ->where('id', '!=', $blog->id)
            ->where('status', ContentStatus::Published)
            ->orderBy('published_at', 'desc')
            ->take(3)
            ->get();

        return view('frontend.pages.blogs.single', compact('blog', 'relatedBlogs'));
    }

    public function storeComment(\Illuminate\Http\Request $request, \App\Models\Blog $blog)
    {
        $validated = $request->validate([
            'name' => auth()->check() ? 'nullable|string|max:255' : 'required|string|max:255',
            'email' => auth()->check() ? 'nullable|email|max:255' : 'required|email|max:255',
            'content' => 'required|string|max:1000',
            'parent_id' => 'nullable|exists:blog_comments,id',
        ]);

        $validated['blog_id'] = $blog->id;
        $validated['status'] = \App\Enums\CommentStatus::Pending;

        if (auth()->check()) {
            $validated['user_id'] = auth()->id();
            $validated['name'] = auth()->user()->name;
            $validated['email'] = auth()->user()->email;
            $validated['status'] = \App\Enums\CommentStatus::Approved; // Auto-approve logged in users, or keep pending based on requirements
        }

        \App\Models\BlogComment::create($validated);

        return back()->with('success', 'Your comment has been submitted and is pending approval.');
    }
}
