<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreBlogRequest;
use App\Http\Requests\Admin\UpdateBlogRequest;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogTag;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    private function getFormData(): array
    {
        return [
            'categories' => BlogCategory::select('id', 'name')->orderBy('name')->get(),
            'tags' => BlogTag::select('id', 'name')->orderBy('name')->get(),
        ];
    }

    public function index(\Illuminate\Http\Request $request): View
    {
        Gate::authorize('view-blogs');

        $query = Blog::with(['category', 'author']);

        // Stats
        $totalCount = Blog::count();
        $publishedCount = Blog::where('status', \App\Enums\ContentStatus::Published->value)->count();
        $draftCount = Blog::where('status', \App\Enums\ContentStatus::Draft->value)->count();
        $totalViews = Blog::sum('views');

        // Search
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%");
            });
        }

        // Filters
        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        if ($category_id = $request->input('category_id')) {
            $query->where('blog_category_id', $category_id);
        }

        $blogs = $query->latest()->paginate(10)->withQueryString();

        $categories = BlogCategory::select('id', 'name')->orderBy('name')->get();

        return view('admin.pages.blogs.index')->with([
            'blogs' => $blogs,
            'totalCount' => $totalCount,
            'publishedCount' => $publishedCount,
            'draftCount' => $draftCount,
            'totalViews' => $totalViews,
            'categories' => $categories
        ]);
    }

    public function create(): View
    {
        Gate::authorize('create-blogs');

        return view('admin.pages.blogs.create')->with($this->getFormData());
    }

    public function store(StoreBlogRequest $request): RedirectResponse
    {
        Gate::authorize('create-blogs');

        $data = $request->validated();
        $data['slug'] = Str::slug($data['title']);
        $data['author_id'] = auth()->id();

        // Handle publishing logic
        if ($data['status'] === \App\Enums\ContentStatus::Published->value) {
            $data['published_at'] = now();
        }

        // upload featured image if exists
        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $request->file('featured_image')->store('blogs/featured_images', 'public');
        }

        $blog = Blog::create($data);

        if (isset($data['tags'])) {
            $blog->tags()->sync($data['tags']);
        }

        // Handle SEO Meta
        $blog->seoMeta()->create([
            'meta_title' => $data['meta_title'] ?? null,
            'meta_description' => $data['meta_description'] ?? null,
        ]);

        return redirect()
            ->route('admin.blog.index')
            ->with('success', 'Blog post created successfully.');
    }

    public function show(Blog $blog): View
    {
        Gate::authorize('view-blogs');

        $blog->load(['category', 'author', 'tags', 'seo']);

        return view('admin.pages.blogs.show')->with(['blog' => $blog]);
    }

    public function edit(Blog $blog): View
    {
        Gate::authorize('edit-blogs');

        $blog->load(['tags', 'seo']);

        return view('admin.pages.blogs.edit')->with(
            array_merge($this->getFormData(), ['blog' => $blog])
        );
    }

    public function update(UpdateBlogRequest $request, Blog $blog): RedirectResponse
    {
        Gate::authorize('edit-blogs');

        $data = $request->validated();

        if ($data['title'] !== $blog->title) {
            $data['slug'] = Str::slug($data['title']);
        }

        // Handle publishing logic
        if ($data['status'] === \App\Enums\ContentStatus::Published->value && !$blog->published_at) {
            $data['published_at'] = now();
        } elseif ($data['status'] === \App\Enums\ContentStatus::Draft->value) {
            $data['published_at'] = null;
        }

        // upload featured image if exists
        if ($request->hasFile('featured_image')) {
            // Delete old image if exists
            if ($blog->featured_image) {
                \Storage::disk('public')->delete($blog->featured_image);
            }
            $data['featured_image'] = $request->file('featured_image')->store('blogs/featured_images', 'public');
        }

        $blog->update($data);

        if (isset($data['tags'])) {
            $blog->tags()->sync($data['tags']);
        } else {
            $blog->tags()->detach();
        }

        // Handle SEO Meta
        $blog->seo()->updateOrCreate(
            ['seoable_id' => $blog->id, 'seoable_type' => Blog::class],
            [
                'meta_title' => $data['meta_title'] ?? null,
                'meta_description' => $data['meta_description'] ?? null,
            ]
        );

        return redirect()
            ->route('admin.blog.index')
            ->with('success', 'Blog post updated successfully.');
    }

    public function destroy(Blog $blog): RedirectResponse
    {
        Gate::authorize('delete-blogs');

        $blog->delete();

        return redirect()
            ->route('admin.blog.index')
            ->with('success', 'Blog post deleted successfully.');
    }
}
