@extends('admin.layouts.admin-master')

@section('title', 'Application Details')

@section('content')
    <div class="heading">
        <div class="d-flex align-items-center">
            <a href="{{ route('admin.job-applications.index') }}" class="btn btn-outline-secondary btn-sm me-3">
                <i class="bi bi-arrow-left"></i> Back
            </a>
            <div>
                <small>APPLICATION DETAILS</small>
                <h1>{{ $jobApplication->name }}</h1>
                <p>Applied for: <strong>{{ $jobApplication->job->title ?? 'Unknown Job' }}</strong></p>
            </div>
        </div>
        <div>
            @can('edit-job-applications')
                <a href="{{ route('admin.job-applications.edit', $jobApplication) }}" class="btn primary">
                    <i class="bi bi-pencil-square me-1"></i> Update Status
                </a>
            @endcan
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card p-4 mb-4">
                <h5 class="mb-4 border-bottom pb-2">Candidate Information</h5>
                
                <div class="row mb-3">
                    <div class="col-sm-4 text-muted">Email:</div>
                    <div class="col-sm-8"><a href="mailto:{{ $jobApplication->email }}">{{ $jobApplication->email }}</a></div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-sm-4 text-muted">Phone:</div>
                    <div class="col-sm-8">{{ $jobApplication->phone ?? 'N/A' }}</div>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-4 text-muted">Address:</div>
                    <div class="col-sm-8">{{ $jobApplication->address ?? 'N/A' }}</div>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-4 text-muted">Applied On:</div>
                    <div class="col-sm-8">{{ $jobApplication->created_at->format('F d, Y h:i A') }}</div>
                </div>
            </div>

            <div class="card p-4 mb-4">
                <h5 class="mb-4 border-bottom pb-2">Cover Letter</h5>
                @if($jobApplication->cover_letter)
                    <div class="bg-light p-3 rounded" style="white-space: pre-wrap;">{{ $jobApplication->cover_letter }}</div>
                @else
                    <p class="text-muted fst-italic">No cover letter provided.</p>
                @endif
            </div>

            <div class="card p-4">
                <h5 class="mb-4 border-bottom pb-2">Internal HR Notes</h5>
                @if($jobApplication->notes)
                    <div class="bg-warning bg-opacity-10 p-3 rounded" style="white-space: pre-wrap; border-left: 4px solid #ffc107;">{{ $jobApplication->notes }}</div>
                @else
                    <p class="text-muted fst-italic">No internal notes added yet.</p>
                @endif
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card p-4 mb-4">
                <h5 class="mb-3 border-bottom pb-2">Current Status</h5>
                @php
                    $statusColor = match($jobApplication->status->value) {
                        'applied' => 'bg-secondary',
                        'shortlisted' => 'bg-primary',
                        'interviewed' => 'bg-info',
                        'offered' => 'bg-warning',
                        'hired' => 'bg-success',
                        'rejected' => 'bg-danger',
                        default => 'bg-secondary'
                    };
                @endphp
                <div class="mb-3">
                    <span class="badge {{ $statusColor }} fs-6 p-2 w-100 text-center">
                        {{ $jobApplication->status->label() }}
                    </span>
                </div>
            </div>

            <div class="card p-4 mb-4">
                <h5 class="mb-3 border-bottom pb-2">Documents & Links</h5>
                
                <div class="d-grid gap-2">
                    @if($jobApplication->cv_file)
                        <a href="{{ Storage::url($jobApplication->cv_file) }}" target="_blank" class="btn btn-outline-primary text-start">
                            <i class="bi bi-file-earmark-pdf me-2"></i> View CV / Resume
                        </a>
                    @else
                        <button class="btn btn-outline-secondary text-start" disabled>
                            <i class="bi bi-file-earmark-x me-2"></i> No CV Attached
                        </button>
                    @endif

                    @if($jobApplication->portfolio_url)
                        <a href="{{ $jobApplication->portfolio_url }}" target="_blank" class="btn btn-outline-info text-start">
                            <i class="bi bi-globe me-2"></i> Portfolio
                        </a>
                    @endif

                    @if($jobApplication->linkedin_url)
                        <a href="{{ $jobApplication->linkedin_url }}" target="_blank" class="btn btn-outline-primary text-start">
                            <i class="bi bi-linkedin me-2"></i> LinkedIn Profile
                        </a>
                    @endif

                    @if($jobApplication->github_url)
                        <a href="{{ $jobApplication->github_url }}" target="_blank" class="btn btn-outline-dark text-start">
                            <i class="bi bi-github me-2"></i> GitHub Profile
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
