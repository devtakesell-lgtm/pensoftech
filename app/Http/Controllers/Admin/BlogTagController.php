<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreBlogTagRequest;
use App\Http\Requests\Admin\UpdateBlogTagRequest;
use App\Models\BlogTag;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use Illuminate\Support\Str;

class BlogTagController extends Controller
{
    public function index(\Illuminate\Http\Request $request): View
    {
        Gate::authorize('view-blog-tags');

        $query = BlogTag::query();

        // Stats
        $totalCount = BlogTag::count();


        // Search
        if ($search = $request->input('search')) {
            $query->where('name', 'like', "%{$search}%");
        }

        $tags = $query->withCount('blogs')->latest()->paginate(10)->withQueryString();

        return view('admin.pages.blog_tags.index')->with([
            'tags' => $tags,
            'totalCount' => $totalCount,
        ]);
    }

    public function create(): View
    {
        Gate::authorize('create-blog-tags');

        return view('admin.pages.blog_tags.create');
    }

    public function store(StoreBlogTagRequest $request): RedirectResponse
    {
        Gate::authorize('create-blog-tags');

        $data = $request->validated();
        $data['slug'] = Str::slug($data['name']);

        BlogTag::create($data);

        return redirect()
            ->route('admin.blog-tags.index')
            ->with('success', 'Blog tag created successfully.');
    }

    public function edit(BlogTag $blogTag): View
    {
        Gate::authorize('edit-blog-tags');

        return view('admin.pages.blog_tags.edit')->with(['blogTag' => $blogTag]);
    }

    public function update(UpdateBlogTagRequest $request, BlogTag $blogTag): RedirectResponse
    {
        Gate::authorize('edit-blog-tags');

        $data = $request->validated();

        if ($data['name'] !== $blogTag->name) {
            $data['slug'] = Str::slug($data['name']);
        }

        $blogTag->update($data);

        return redirect()
            ->route('admin.blog-tags.index')
            ->with('success', 'Blog tag updated successfully.');
    }

    public function destroy(BlogTag $blogTag): RedirectResponse
    {
        Gate::authorize('delete-blog-tags');

        $blogTag->delete();

        return redirect()
            ->route('admin.blog-tags.index')
            ->with('success', 'Blog tag deleted successfully.');
    }
}
