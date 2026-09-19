<?php

namespace App\Http\Controllers\Admin;

use App\Enums\EmploymentType;
use App\Enums\JobStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreJobRequest;
use App\Http\Requests\Admin\UpdateJobRequest;
use App\Models\Job;
use App\Models\JobCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class JobController extends Controller
{
    public function index(Request $request): View
    {
        Gate::authorize('view-jobs');

        $query = Job::with('category')->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        return view('admin.pages.jobs.index')->with([
            'jobs' => $query->paginate(15)->withQueryString(),
            'currentSearch' => $request->search,
            'currentStatus' => $request->status,
            'statuses' => JobStatus::cases(),
        ]);
    }

    private function getFormData(): array
    {
        return [
            'categories' => JobCategory::orderBy('name')->get(),
            'employmentTypes' => EmploymentType::cases(),
            'statuses' => JobStatus::cases(),
        ];
    }

    public function create(): View
    {
        Gate::authorize('create-jobs');

        return view('admin.pages.jobs.create')->with($this->getFormData());
    }

    public function store(StoreJobRequest $request): RedirectResponse
    {
        Job::create($request->validated());

        return redirect()
            ->route('admin.jobs.index')
            ->with('success', 'Job listing created successfully.');
    }

    public function edit(Job $job): View
    {
        Gate::authorize('edit-jobs');

        return view('admin.pages.jobs.edit')->with(
            array_merge($this->getFormData(), ['job' => $job])
        );
    }

    public function update(UpdateJobRequest $request, Job $job): RedirectResponse
    {
        $job->update($request->validated());

        return redirect()
            ->route('admin.jobs.index')
            ->with('success', 'Job listing updated successfully.');
    }

    public function destroy(Job $job): RedirectResponse
    {
        Gate::authorize('delete-jobs');

        // Check for applications here when applications module is built.
        // For now, just soft delete.

        $job->delete();

        return redirect()
            ->route('admin.jobs.index')
            ->with('success', 'Job listing deleted successfully.');
    }
}
