<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ContentStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreServiceRequest;
use App\Http\Requests\Admin\UpdateServiceRequest;
use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ServiceController extends Controller
{
    /**
     * Display a listing of agency services.
     */
    public function index(Request $request): View
    {
        Gate::authorize('view-services');

        $query = Service::with('category')->withCount('projects');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%")
                    ->orWhere('short_description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('service_category_id', $request->input('category'));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $services = $query->orderBy('sort_order', 'asc')->latest()->paginate(10)->withQueryString();
        $categories = ServiceCategory::select('id', 'name')->orderBy('name')->get();

        return view('admin.pages.services.index')->with([
            'services' => $services,
            'categories' => $categories,
            'statuses' => ContentStatus::cases(),
            'currentSearch' => $request->input('search', ''),
            'currentCategory' => $request->input('category', ''),
            'currentStatus' => $request->input('status', ''),
        ]);
    }

    /**
     * Show the form for creating a new service.
     */
    public function create(): View
    {
        Gate::authorize('create-services');

        $categories = ServiceCategory::select('id', 'name')->orderBy('name')->get();

        return view('admin.pages.services.create')->with([
            'categories' => $categories,
            'statuses' => ContentStatus::cases(),
        ]);
    }

    /**
     * Store a newly created service in storage.
     */
    public function store(StoreServiceRequest $request): RedirectResponse
    {
        Gate::authorize('create-services');

        $slug = $request->validated('slug')
            ? Str::slug($request->validated('slug'))
            : Str::slug($request->validated('name'));

        // Handle image file uploads
        $featuredImagePath = null;
        if ($request->hasFile('featured_image')) {
            $featuredImagePath = $request->file('featured_image')->store('services', 'public');
        }

        $bannerImagePath = null;
        if ($request->hasFile('banner_image')) {
            $bannerImagePath = $request->file('banner_image')->store('services', 'public');
        }

        $service = Service::create([
            'service_category_id' => $request->validated('service_category_id'),
            'name' => $request->validated('name'),
            'slug' => $slug,
            'short_description' => $request->validated('short_description'),
            'description' => $request->validated('description'),
            'icon' => $request->validated('icon'),
            'featured_image' => $featuredImagePath,
            'banner_image' => $bannerImagePath,
            'status' => $request->validated('status'),
            'is_featured' => $request->boolean('is_featured', false),
            'sort_order' => (int) $request->input('sort_order', 0),
        ]);

        return redirect()->route('admin.services')->with('success', "Service '{$service->name}' created successfully.");
    }

    /**
     * Show the form for editing an existing service.
     */
    public function edit(Service $service): View
    {
        Gate::authorize('edit-services');

        $categories = ServiceCategory::select('id', 'name')->orderBy('name')->get();

        return view('admin.pages.services.edit')->with([
            'service' => $service,
            'categories' => $categories,
            'statuses' => ContentStatus::cases(),
        ]);
    }

    /**
     * Update the specified service in storage.
     */
    public function update(UpdateServiceRequest $request, Service $service): RedirectResponse
    {
        Gate::authorize('edit-services');

        $data = [
            'service_category_id' => $request->validated('service_category_id'),
            'name' => $request->validated('name'),
            'slug' => Str::slug($request->validated('slug')),
            'short_description' => $request->validated('short_description'),
            'description' => $request->validated('description'),
            'icon' => $request->validated('icon'),
            'status' => $request->validated('status'),
            'is_featured' => $request->boolean('is_featured', false),
            'sort_order' => (int) $request->input('sort_order', 0),
        ];

        // Handle featured image replacement
        if ($request->hasFile('featured_image')) {
            if ($service->featured_image && Storage::disk('public')->exists($service->featured_image)) {
                Storage::disk('public')->delete($service->featured_image);
            }
            $data['featured_image'] = $request->file('featured_image')->store('services', 'public');
        }

        // Handle banner image replacement
        if ($request->hasFile('banner_image')) {
            if ($service->banner_image && Storage::disk('public')->exists($service->banner_image)) {
                Storage::disk('public')->delete($service->banner_image);
            }
            $data['banner_image'] = $request->file('banner_image')->store('services', 'public');
        }

        $service->update($data);

        return redirect()->route('admin.services')->with('success', "Service '{$service->name}' updated successfully.");
    }

    /**
     * Remove the specified service from storage with deletion safeguarding.
     */
    public function destroy(Service $service): RedirectResponse
    {
        Gate::authorize('delete-services');

        // Safeguard: Prevent deleting services linked to projects or leads
        if ($service->projects()->exists() || $service->leads()->exists()) {
            return redirect()->route('admin.services')->with('error', "Cannot delete service '{$service->name}' because it is linked to existing projects or leads.");
        }

        // Clean up uploaded media files
        if ($service->featured_image && Storage::disk('public')->exists($service->featured_image)) {
            Storage::disk('public')->delete($service->featured_image);
        }

        if ($service->banner_image && Storage::disk('public')->exists($service->banner_image)) {
            Storage::disk('public')->delete($service->banner_image);
        }

        $serviceName = $service->name;
        $service->delete();

        return redirect()->route('admin.services')->with('success', "Service '{$serviceName}' deleted successfully.");
    }
}
