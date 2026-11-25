<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCourseCategoryRequest;
use App\Http\Requests\Admin\UpdateCourseCategoryRequest;
use App\Models\CourseCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class CourseCategoryController extends Controller
{
    public function index(Request $request): View
    {
        Gate::authorize('view-courses');

        $query = CourseCategory::select('id', 'name', 'slug', 'icon', 'description', 'is_active', 'order', 'created_at')
            ->withCount('courses');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        $categories = $query->orderBy('order')->latest()->paginate(10)->withQueryString();

        return view('admin.pages.course-categories.index')->with([
            'categories' => $categories,
            'currentSearch' => $request->input('search', ''),
        ]);
    }

    public function create(): View
    {
        Gate::authorize('create-courses');

        return view('admin.pages.course-categories.create');
    }

    public function store(StoreCourseCategoryRequest $request): RedirectResponse
    {
        $category = CourseCategory::create($request->validated());

        return redirect()->route('admin.course-categories.index')
            ->with('success', "Course Category '{$category->name}' created successfully.");
    }

    public function edit(CourseCategory $courseCategory): View
    {
        Gate::authorize('edit-courses');

        return view('admin.pages.course-categories.edit')->with([
            'category' => $courseCategory,
        ]);
    }

    public function update(UpdateCourseCategoryRequest $request, CourseCategory $courseCategory): RedirectResponse
    {
        $courseCategory->update($request->validated());

        return redirect()->route('admin.course-categories.index')
            ->with('success', "Course Category '{$courseCategory->name}' updated successfully.");
    }

    public function destroy(CourseCategory $courseCategory): RedirectResponse
    {
        Gate::authorize('delete-courses');

        if ($courseCategory->courses()->count() > 0) {
            return redirect()->route('admin.course-categories.index')
                ->with('error', "Cannot delete category '{$courseCategory->name}' because it contains courses.");
        }

        $courseCategory->delete();

        return redirect()->route('admin.course-categories.index')
            ->with('success', "Course Category '{$courseCategory->name}' deleted successfully.");
    }
}
