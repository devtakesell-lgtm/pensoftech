<?php

namespace App\Http\Controllers\Admin;

use App\Enums\JobApplicationStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateJobApplicationRequest;
use App\Mail\JobApplicationStatusUpdated;
use App\Models\JobApplication;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class JobApplicationController extends Controller
{
    public function index(): View
    {
        Gate::authorize('view-job-applications');

        $jobApplications = JobApplication::with('job')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.pages.job_applications.index')->with([
            'jobApplications' => $jobApplications,
        ]);
    }

    public function show(JobApplication $jobApplication): View
    {
        Gate::authorize('view-job-applications');

        $jobApplication->load('job');

        return view('admin.pages.job_applications.show')->with([
            'jobApplication' => $jobApplication,
        ]);
    }

    public function edit(JobApplication $jobApplication): View
    {
        Gate::authorize('edit-job-applications');

        $jobApplication->load('job');

        return view('admin.pages.job_applications.edit')->with([
            'jobApplication' => $jobApplication,
            'statuses' => JobApplicationStatus::cases(),
        ]);
    }

    public function update(UpdateJobApplicationRequest $request, JobApplication $jobApplication): RedirectResponse
    {
        Gate::authorize('edit-job-applications');

        $jobApplication->update([
            'status' => $request->validated('status'),
            'notes' => $request->validated('notes'),
        ]);

        if ($request->boolean('notify_candidate')) {
            Mail::to($jobApplication->email)->send(new JobApplicationStatusUpdated($jobApplication));
        }

        return redirect()->route('admin.job-applications.index')
            ->with('success', 'Job application updated successfully.');
    }

    public function destroy(JobApplication $jobApplication): RedirectResponse
    {
        Gate::authorize('delete-job-applications');

        if ($jobApplication->cv_file) {
            Storage::disk('public')->delete($jobApplication->cv_file);
        }

        $jobApplication->delete();

        return redirect()->route('admin.job-applications.index')
            ->with('success', 'Job application deleted successfully.');
    }
}
