<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreBlogCategoryRequest;
use App\Http\Requests\Admin\UpdateBlogCategoryRequest;
use App\Models\BlogCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use Illuminate\Support\Str;

class BlogCategoryController extends Controller
{
    public function index(\Illuminate\Http\Request $request): View
    {
        Gate::authorize('view-blog-categories');

        $query = BlogCategory::query();

        // Stats
        $totalCount = BlogCategory::count();
        $activeCount = BlogCategory::where('is_active', true)->count();
        $inactiveCount = BlogCategory::where('is_active', false)->count();

        // Search
        if ($search = $request->input('search')) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
        }

        // Filters
        if ($request->has('status') && $request->input('status') !== '') {
            $query->where('is_active', $request->input('status'));
        }

        $categories = $query->withCount('blogs')->latest()->paginate(10)->withQueryString();

        return view('admin.pages.blog_categories.index')->with([
            'categories' => $categories,
            'totalCount' => $totalCount,
            'activeCount' => $activeCount,
            'inactiveCount' => $inactiveCount
        ]);
    }

    public function create(): View
    {
        Gate::authorize('create-blog-categories');

        return view('admin.pages.blog_categories.create');
    }

    public function store(StoreBlogCategoryRequest $request): RedirectResponse
    {
        Gate::authorize('create-blog-categories');

        $data = $request->validated();
        $data['slug'] = Str::slug($data['name']);

        BlogCategory::create($data);

        return redirect()
            ->route('admin.blog-categories.index')
            ->with('success', 'Blog category created successfully.');
    }

    public function edit(BlogCategory $blogCategory): View
    {
        Gate::authorize('edit-blog-categories');

        return view('admin.pages.blog_categories.edit')->with(['blogCategory' => $blogCategory]);
    }

    public function update(UpdateBlogCategoryRequest $request, BlogCategory $blogCategory): RedirectResponse
    {
        Gate::authorize('edit-blog-categories');

        $data = $request->validated();

        if ($data['name'] !== $blogCategory->name) {
            $data['slug'] = Str::slug($data['name']);
        }

        $blogCategory->update($data);

        return redirect()
            ->route('admin.blog-categories.index')
            ->with('success', 'Blog category updated successfully.');
    }

    public function destroy(BlogCategory $blogCategory): RedirectResponse
    {
        Gate::authorize('delete-blog-categories');

        if ($blogCategory->blogs()->count() > 0) {
            return redirect()
                ->route('admin.blog-categories.index')
                ->with('error', 'Cannot delete category because it has associated blog posts.');
        }

        $blogCategory->delete();

        return redirect()
            ->route('admin.blog-categories.index')
            ->with('success', 'Blog category deleted successfully.');
    }
}
