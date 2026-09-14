<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreIndustryRequest;
use App\Http\Requests\Admin\UpdateIndustryRequest;
use App\Models\Industry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Illuminate\View\View;

class IndustryController extends Controller
{
    /**
     * Display a listing of client business industries.
     */
    public function index(Request $request): View
    {
        Gate::authorize('view-industries');

        $query = Industry::withCount('projects');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%");
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->input('status') === 'active');
        }

        $industries = $query->orderBy('sort_order', 'asc')
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.pages.industries.index')->with([
            'industries' => $industries,
            'currentSearch' => $request->input('search'),
            'currentStatus' => $request->input('status'),
            'totalCount' => Industry::count(),
            'activeCount' => Industry::where('is_active', true)->count(),
        ]);
    }

    /**
     * Show the form for creating a new industry.
     */
    public function create(): View
    {
        Gate::authorize('create-industries');

        return view('admin.pages.industries.create');
    }

    /**
     * Store a newly created industry in storage.
     */
    public function store(StoreIndustryRequest $request): RedirectResponse
    {
        Gate::authorize('create-industries');

        $data = $request->validated();
        $data['slug'] = Str::slug($data['name']);

        Industry::create($data);

        return redirect()->route('admin.industries')
            ->with('success', 'Industry created successfully.');
    }

    /**
     * Show the form for editing the specified industry.
     */
    public function edit(Industry $industry): View
    {
        Gate::authorize('edit-industries');

        return view('admin.pages.industries.edit')->with([
            'industry' => $industry,
        ]);
    }

    /**
     * Update the specified industry in storage.
     */
    public function update(UpdateIndustryRequest $request, Industry $industry): RedirectResponse
    {
        Gate::authorize('edit-industries');

        $data = $request->validated();

        if ($industry->name !== $data['name']) {
            $data['slug'] = Str::slug($data['name']);
        }

        $industry->update($data);

        return redirect()->route('admin.industries')
            ->with('success', 'Industry updated successfully.');
    }

    /**
     * Remove the specified industry from storage.
     */
    public function destroy(Industry $industry): RedirectResponse
    {
        Gate::authorize('delete-industries');

        if ($industry->projects()->exists() || $industry->leads()->exists()) {
            return back()->with('error', 'Cannot delete industry because it has associated projects or leads.');
        }

        $industry->delete();

        return redirect()->route('admin.industries')
            ->with('success', 'Industry deleted successfully.');
    }
}
