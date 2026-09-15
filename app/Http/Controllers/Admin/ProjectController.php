<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ProjectStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreProjectRequest;
use App\Http\Requests\Admin\UpdateProjectRequest;
use App\Models\Client;
use App\Models\Industry;
use App\Models\Project;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProjectController extends Controller
{
    /**
     * Display a listing of agency client projects.
     */
    public function index(\Illuminate\Http\Request $request): View
    {
        Gate::authorize('view-projects');

        $filters = $request->only(['search', 'status', 'industry_id']);

        $projects = Project::query()
            ->filter($filters)
            ->with(['client', 'services'])
            ->latest()
            ->paginate(15)
            ->withQueryString();

        // KPIs
        $totalCount = Project::count();
        $upcomingCount = Project::where('status', ProjectStatus::Upcoming)->count();
        $ongoingCount = Project::where('status', ProjectStatus::Ongoing)->count();
        $completedCount = Project::where('status', ProjectStatus::Completed)->count();

        $industries = Industry::select('id', 'name')->orderBy('name')->get();

        return view('admin.pages.projects.index')->with([
            'projects' => $projects,
            'statuses' => ProjectStatus::cases(),
            'industries' => $industries,
            'totalCount' => $totalCount,
            'upcomingCount' => $upcomingCount,
            'ongoingCount' => $ongoingCount,
            'completedCount' => $completedCount,
            'currentSearch' => $filters['search'] ?? '',
            'currentStatus' => $filters['status'] ?? '',
            'currentIndustry' => $filters['industry_id'] ?? '',
        ]);
    }

    /**
     * Show the form for creating a new project.
     */
    public function create(): View
    {
        Gate::authorize('create-projects');

        return view('admin.pages.projects.create')->with($this->getFormData(true));
    }

    /**
     * Store a newly created project in storage.
     */
    public function store(StoreProjectRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $validated['slug'] = Str::slug($validated['title']);

        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')->store('projects', 'public');
        }

        $project = Project::create($validated);

        if ($request->has('services')) {
            $project->services()->sync($request->input('services'));
        }

        return redirect()->route('admin.projects.show', $project)
            ->with('success', 'Project created successfully.');
    }

    /**
     * Display the specified project.
     */
    public function show(Project $project): View
    {
        Gate::authorize('view-projects');

        $project->load(['client', 'services', 'industry']);

        return view('admin.pages.projects.show')->with([
            'project' => $project,
        ]);
    }

    /**
     * Show the form for editing the specified project.
     */
    public function edit(Project $project): View
    {
        Gate::authorize('edit-projects');

        return view('admin.pages.projects.edit')->with(
            array_merge($this->getFormData(false), ['project' => $project])
        );
    }

    /**
     * Update the specified project in storage.
     */
    public function update(UpdateProjectRequest $request, Project $project): RedirectResponse
    {
        $validated = $request->validated();

        if ($project->title !== $validated['title']) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        // Prevent status change if already completed
        if ($project->status === ProjectStatus::Completed && isset($validated['status']) && $validated['status'] !== ProjectStatus::Completed->value) {
            $validated['status'] = ProjectStatus::Completed->value; // Ignore the status change
        }

        if ($request->hasFile('featured_image')) {
            if ($project->featured_image) {
                Storage::disk('public')->delete($project->featured_image);
            }
            $validated['featured_image'] = $request->file('featured_image')->store('projects', 'public');
        }

        $project->update($validated);

        if ($request->has('services')) {
            $project->services()->sync($request->input('services'));
        } else {
            $project->services()->detach();
        }

        return redirect()->route('admin.projects.show', $project)
            ->with('success', 'Project updated successfully.');
    }

    /**
     * Remove the specified project from storage.
     */
    public function destroy(Project $project): RedirectResponse
    {
        Gate::authorize('delete-projects');

        $project->delete();

        return redirect()->route('admin.projects.index')
            ->with('success', 'Project deleted successfully.');
    }

    public function updateStatus(\Illuminate\Http\Request $request, Project $project): RedirectResponse
    {
        Gate::authorize('edit-projects');

        if ($project->status === ProjectStatus::Completed) {
            return back()->with('error', 'Completed projects cannot change status.');
        }

        $validated = $request->validate([
            'status' => ['required', \Illuminate\Validation\Rule::enum(ProjectStatus::class)],
        ]);

        $project->update(['status' => $validated['status']]);

        return back()->with('success', "Project status updated to '{$project->status->label()}'.");
    }

    /**
     * Fetch lookup arrays for forms.
     */
    private function getFormData(bool $isCreate = false): array
    {
        return [
            'clients' => Client::select('id', 'contact_person')->orderBy('contact_person')->get(),
            'industries' => Industry::select('id', 'name')->orderBy('name')->get(),
            'services' => Service::select('id', 'name')->orderBy('name')->get(),
            'statuses' => $isCreate 
                ? [ProjectStatus::Upcoming, ProjectStatus::Ongoing] 
                : ProjectStatus::cases(),
        ];
    }
}
