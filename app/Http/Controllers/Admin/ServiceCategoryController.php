<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreServiceCategoryRequest;
use App\Http\Requests\Admin\UpdateServiceCategoryRequest;
use App\Models\ServiceCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ServiceCategoryController extends Controller
{
    /**
     * Display a listing of the service categories.
     */
    public function index(Request $request): View
    {
        Gate::authorize('view-services');

        $query = ServiceCategory::select(
            'id',
            'name',
            'slug',
            'short_description',
            'icon',
            'image',
            'sort_order',
            'is_active',
            'created_at'
        )->withCount('services');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%")
                    ->orWhere('short_description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $isActive = $request->input('status') === 'active';
            $query->where('is_active', $isActive);
        }

        $categories = $query->orderBy('sort_order', 'asc')->latest()->paginate(10)->withQueryString();

        return view('admin.pages.service-categories.index')->with([
            'categories' => $categories,
            'currentSearch' => $request->input('search', ''),
            'currentStatus' => $request->input('status', ''),
        ]);
    }

    /**
     * Show the form for creating a new service category.
     */
    public function create(): View
    {
        Gate::authorize('create-services');

        return view('admin.pages.service-categories.create');
    }

    /**
     * Store a newly created service category in storage.
     */
    public function store(StoreServiceCategoryRequest $request): RedirectResponse
    {
        Gate::authorize('create-services');

        $slug = $request->validated('slug')
            ? Str::slug($request->validated('slug'))
            : Str::slug($request->validated('name'));

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('service-categories', 'public');
        }

        $category = ServiceCategory::create([
            'name' => $request->validated('name'),
            'slug' => $slug,
            'short_description' => $request->validated('short_description'),
            'description' => $request->validated('description'),
            'icon' => $request->validated('icon'),
            'image' => $imagePath,
            'sort_order' => (int) $request->input('sort_order', 0),
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.service-categories.index')
            ->with('success', "Service Category '{$category->name}' created successfully.");
    }

    /**
     * Show the form for editing an existing service category.
     */
    public function edit(ServiceCategory $serviceCategory): View
    {
        Gate::authorize('edit-services');

        return view('admin.pages.service-categories.edit')->with([
            'category' => $serviceCategory,
        ]);
    }

    /**
     * Update the specified service category in storage.
     */
    public function update(UpdateServiceCategoryRequest $request, ServiceCategory $serviceCategory): RedirectResponse
    {
        Gate::authorize('edit-services');

        $slug = $request->validated('slug')
            ? Str::slug($request->validated('slug'))
            : Str::slug($request->validated('name'));

        $imagePath = $serviceCategory->image;
        if ($request->hasFile('image')) {
            if ($imagePath && Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }
            $imagePath = $request->file('image')->store('service-categories', 'public');
        }

        $serviceCategory->update([
            'name' => $request->validated('name'),
            'slug' => $slug,
            'short_description' => $request->validated('short_description'),
            'description' => $request->validated('description'),
            'icon' => $request->validated('icon'),
            'image' => $imagePath,
            'sort_order' => (int) $request->input('sort_order', 0),
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.service-categories.index')
            ->with('success', "Service Category '{$serviceCategory->name}' updated successfully.");
    }

    /**
     * Remove the specified service category from storage.
     */
    public function destroy(ServiceCategory $serviceCategory): RedirectResponse
    {
        Gate::authorize('delete-services');

        // Deletion Safeguard: Cannot delete if linked to existing services
        if ($serviceCategory->services()->exists()) {
            $count = $serviceCategory->services()->count();

            return redirect()->route('admin.service-categories.index')
                ->with('error', "Cannot delete category '{$serviceCategory->name}' because it has {$count} active service(s) associated with it. Please reassign or delete them first.");
        }

        // Clean up stored image file if exists
        if ($serviceCategory->image && Storage::disk('public')->exists($serviceCategory->image)) {
            Storage::disk('public')->delete($serviceCategory->image);
        }

        $categoryName = $serviceCategory->name;
        $serviceCategory->delete();

        return redirect()->route('admin.service-categories.index')
            ->with('success', "Service Category '{$categoryName}' deleted successfully.");
    }
}
