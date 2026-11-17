<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreJobCategoryRequest;
use App\Http\Requests\Admin\UpdateJobCategoryRequest;
use App\Models\JobCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Illuminate\View\View;

class JobCategoryController extends Controller
{
    /**
     * Display a listing of the job categories.
     */
    public function index(Request $request): View
    {
        Gate::authorize('view-jobs');

        $query = JobCategory::select('id', 'name', 'slug', 'created_at')
            ->withCount('jobs');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        $categories = $query->latest()->paginate(10)->withQueryString();

        return view('admin.pages.job-categories.index')->with([
            'categories' => $categories,
            'currentSearch' => $request->input('search', ''),
        ]);
    }

    /**
     * Show the form for creating a new job category.
     */
    public function create(): View
    {
        Gate::authorize('create-jobs');

        return view('admin.pages.job-categories.create');
    }

    /**
     * Store a newly created job category in storage.
     */
    public function store(StoreJobCategoryRequest $request): RedirectResponse
    {
        Gate::authorize('create-jobs');

        $slug = $request->validated('slug')
            ? Str::slug($request->validated('slug'))
            : Str::slug($request->validated('name'));

        $category = JobCategory::create([
            'name' => $request->validated('name'),
            'slug' => $slug,
        ]);

        return redirect()->route('admin.job-categories.index')
            ->with('success', "Job Category '{$category->name}' created successfully.");
    }

    /**
     * Show the form for editing an existing job category.
     */
    public function edit(JobCategory $jobCategory): View
    {
        Gate::authorize('edit-jobs');

        return view('admin.pages.job-categories.edit')->with([
            'category' => $jobCategory,
        ]);
    }

    /**
     * Update the specified job category in storage.
     */
    public function update(UpdateJobCategoryRequest $request, JobCategory $jobCategory): RedirectResponse
    {
        Gate::authorize('edit-jobs');

        $slug = $request->validated('slug')
            ? Str::slug($request->validated('slug'))
            : Str::slug($request->validated('name'));

        $jobCategory->update([
            'name' => $request->validated('name'),
            'slug' => $slug,
        ]);

        return redirect()->route('admin.job-categories.index')
            ->with('success', "Job Category '{$jobCategory->name}' updated successfully.");
    }

    /**
     * Remove the specified job category from storage.
     */
    public function destroy(JobCategory $jobCategory): RedirectResponse
    {
        Gate::authorize('delete-jobs');

        if ($jobCategory->jobs()->exists()) {
            $count = $jobCategory->jobs()->count();

            return redirect()->route('admin.job-categories.index')
                ->with('error', "Cannot delete category '{$jobCategory->name}' because it has {$count} active job(s) associated with it. Please reassign or delete them first.");
        }

        $categoryName = $jobCategory->name;
        $jobCategory->delete();

        return redirect()->route('admin.job-categories.index')
            ->with('success', "Job Category '{$categoryName}' deleted successfully.");
    }
}
