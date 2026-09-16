<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ContentStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePageRequest;
use App\Http\Requests\Admin\UpdatePageRequest;
use App\Models\Page;
use App\Services\PageService;
use App\Traits\HandlesImageUploads;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class PageController extends Controller
{
    /**
     * Display a listing of CMS pages.
     */
    use HandlesImageUploads;

    public function index(): View
    {
        Gate::authorize('view-pages');

        $pages = Page::latest()->paginate(10);

        return view('admin.pages.cms-pages.index')->with([
            'pages' => $pages,
        ]);
    }

    public function create(): View
    {
        Gate::authorize('create-pages');

        return view('admin.pages.cms-pages.create')->with([
            'contentStatuses' => ContentStatus::cases(),
        ]);
    }

    public function store(StorePageRequest $request, PageService $pageService): RedirectResponse
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $validated['featured_image'] = $this->handleImageUpload($request->file('image'), 'pages', 1200);
        }

        $pageService->storePage($validated);

        return redirect()->route('admin.pages.index')
            ->with('success', 'Page created successfully.');
    }

    public function show(Page $page): View
    {
        Gate::authorize('view-pages');

        return view('admin.pages.cms-pages.show')->with([
            'page' => $page,
        ]);
    }

    public function edit(Page $page): View
    {
        Gate::authorize('edit-pages');

        return view('admin.pages.cms-pages.edit')->with([
            'page' => $page,
            'contentStatuses' => ContentStatus::cases(),
        ]);
    }

    public function update(UpdatePageRequest $request, Page $page, PageService $pageService): RedirectResponse
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $validated['featured_image'] = $this->handleImageUpload($request->file('image'), 'pages', 1200, $page->featured_image);
        }

        $pageService->updatePage($page, $validated);

        return redirect()->route('admin.pages.index')
            ->with('success', 'Page updated successfully.');
    }

    public function destroy(Page $page): RedirectResponse
    {
        Gate::authorize('delete-pages');

        $this->deleteImage($page->featured_image);
        $page->delete();

        return redirect()->route('admin.pages.index')
            ->with('success', 'Page deleted successfully.');
    }
}
