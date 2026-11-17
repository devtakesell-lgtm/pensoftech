<?php

namespace App\Http\Controllers\Frontend;

use App\Enums\EmploymentType;
use App\Enums\JobApplicationStatus;
use App\Enums\JobStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\StoreJobApplicationRequest;
use App\Models\Job;
use App\Models\JobApplication;
use App\Models\JobCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CareerController extends Controller
{
    public function index(Request $request): View
    {
        $filters = $request->only(['search', 'category', 'type']);
        $search = $filters['search'] ?? null;
        $categorySlug = $filters['category'] ?? null;
        $employmentTypeValue = $filters['type'] ?? null;

        $jobsQuery = Job::query()
            ->where('status', JobStatus::Open)
            ->where('deadline', '>=', now())
            ->with(['category', 'seo']);

        if (! empty($search)) {
            $jobsQuery->where(function ($query) use ($search) {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if (! empty($categorySlug)) {
            $jobsQuery->whereHas('category', function ($query) use ($categorySlug) {
                $query->where('slug', $categorySlug);
            });
        }

        if (! empty($employmentTypeValue)) {
            $jobsQuery->where('employment_type', $employmentTypeValue);
        }

        $jobs = $jobsQuery->latest()->get();

        $categories = JobCategory::query()
            ->select('id', 'name', 'slug')
            ->whereHas('jobs', fn ($q) => $q->where('status', JobStatus::Open))
            ->orderBy('name')
            ->get();

        $totalOpenRoles = Job::query()
            ->where('status', JobStatus::Open)
            ->count();

        return view('frontend.pages.careers.index')->with([
            'jobs' => $jobs,
            'categories' => $categories,
            'employmentTypes' => EmploymentType::cases(),
            'totalOpenRoles' => $totalOpenRoles,
            'selectedCategory' => $categorySlug,
            'selectedType' => $employmentTypeValue,
            'searchQuery' => $search,
        ]);
    }

    public function show(string $slug): View
    {
        $job = Job::query()
            ->where('slug', $slug)
            ->where('status', JobStatus::Open)
            ->with(['category', 'seo'])
            ->firstOrFail();

        $relatedJobs = Job::query()
            ->where('status', JobStatus::Open)
            ->where('id', '!=', $job->id)
            ->when($job->job_category_id, fn ($q) => $q->where('job_category_id', $job->job_category_id))
            ->limit(3)
            ->get();

        return view('frontend.pages.careers.show')->with([
            'job' => $job,
            'relatedJobs' => $relatedJobs,
        ]);
    }

    public function apply(StoreJobApplicationRequest $request, string $slug): RedirectResponse
    {
        $job = Job::query()
            ->where('slug', $slug)
            ->where('status', JobStatus::Open)
            ->firstOrFail();

        $filePath = $request->file('cv_file')->store('resumes', 'public');

        JobApplication::create([
            'job_id' => $job->id,
            'name' => $request->validated('name'),
            'email' => $request->validated('email'),
            'phone' => $request->validated('phone'),
            'address' => $request->validated('address'),
            'cv_file' => $filePath,
            'cover_letter' => $request->validated('cover_letter'),
            'linkedin_url' => $request->validated('linkedin_url'),
            'portfolio_url' => $request->validated('portfolio_url'),
            'github_url' => $request->validated('github_url'),
            'status' => JobApplicationStatus::Applied,
        ]);

        return redirect()->route('careers.show', $job->slug)->with(
            'success',
            'Your application has been received! Our leadership squad will review your profile shortly.'
        );
    }
}
