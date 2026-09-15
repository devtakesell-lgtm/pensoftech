<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCaseStudyRequest;
use App\Http\Requests\Admin\UpdateCaseStudyRequest;
use App\Models\CaseStudy;
use App\Models\Project;
use App\Traits\HandlesImageUploads;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CaseStudyController extends Controller
{
    use HandlesImageUploads;

    public function index(): View
    {
        Gate::authorize('view-case-studies');

        $caseStudies = CaseStudy::with('project')->latest()->paginate(10);

        return view('admin.pages.case-studies.index')->with([
            'caseStudies' => $caseStudies,
        ]);
    }

    public function create(): View
    {
        Gate::authorize('create-case-studies');

        $projects = Project::where('status', 'Completed')->latest()->get();

        return view('admin.pages.case-studies.create')->with([
            'projects' => $projects,
        ]);
    }

    public function store(StoreCaseStudyRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $validated['slug'] = Str::slug($validated['title']);
        $validated['featured_image'] = $this->handleImageUpload($request->file('image'), 'case-studies', 1200);

        $caseStudy = CaseStudy::create($validated);

        if (isset($validated['metrics']) && is_array($validated['metrics'])) {
            $metricsData = [];
            foreach ($validated['metrics'] as $index => $metric) {
                if (!empty($metric['metric_name'])) {
                    $metricsData[] = [
                        'metric_name' => $metric['metric_name'],
                        'metric_value' => $metric['metric_value'] ?? null,
                        'metric_suffix' => $metric['metric_suffix'] ?? null,
                        'sort_order' => $index,
                    ];
                }
            }
            if (!empty($metricsData)) {
                $caseStudy->metrics()->createMany($metricsData);
            }
        }

        return redirect()->route('admin.case-studies.index')
            ->with('success', 'Case Study created successfully.');
    }

    public function show(CaseStudy $caseStudy): View
    {
        Gate::authorize('view-case-studies');

        $caseStudy->load(['project', 'metrics']);

        return view('admin.pages.case-studies.show')->with([
            'caseStudy' => $caseStudy,
        ]);
    }

    public function edit(CaseStudy $caseStudy): View
    {
        Gate::authorize('edit-case-studies');

        $caseStudy->load('metrics');
        $projects = Project::where('status', 'Completed')->latest()->get();

        return view('admin.pages.case-studies.edit')->with([
            'caseStudy' => $caseStudy,
            'projects' => $projects,
        ]);
    }

    public function update(UpdateCaseStudyRequest $request, CaseStudy $caseStudy): RedirectResponse
    {
        $validated = $request->validated();

        $validated['slug'] = Str::slug($validated['title']);

        if ($request->hasFile('image')) {
            $validated['featured_image'] = $this->handleImageUpload($request->file('image'), 'case-studies', 1200, $caseStudy->featured_image);
        }

        $caseStudy->update($validated);

        // Sync metrics - delete old ones and recreate to keep it simple
        $caseStudy->metrics()->delete();

        if (isset($validated['metrics']) && is_array($validated['metrics'])) {
            $metricsData = [];
            foreach ($validated['metrics'] as $index => $metric) {
                if (!empty($metric['metric_name'])) {
                    $metricsData[] = [
                        'metric_name' => $metric['metric_name'],
                        'metric_value' => $metric['metric_value'] ?? null,
                        'metric_suffix' => $metric['metric_suffix'] ?? null,
                        'sort_order' => $index,
                    ];
                }
            }
            if (!empty($metricsData)) {
                $caseStudy->metrics()->createMany($metricsData);
            }
        }

        return redirect()->route('admin.case-studies.index')
            ->with('success', 'Case Study updated successfully.');
    }

    public function destroy(CaseStudy $caseStudy): RedirectResponse
    {
        Gate::authorize('delete-case-studies');

        $this->deleteImage($caseStudy->featured_image);
        $caseStudy->metrics()->delete();
        $caseStudy->delete();

        return redirect()->route('admin.case-studies.index')
            ->with('success', 'Case Study deleted successfully.');
    }
}
