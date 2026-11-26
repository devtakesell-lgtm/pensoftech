@extends('admin.layouts.admin-master')

@section('title', 'Learner Profile — ' . $learner->name)

@section('content')
    <div class="heading">
        <div>
            <small>LEARNER PROFILE</small>
            <h1>{{ $learner->name }}</h1>
            <p>
                Learner Code: <strong>{{ $learner->learner_code }}</strong> •
                {{ $learner->email }}
            </p>
        </div>
        <div>
            <a href="{{ route('admin.learners.index') }}" class="btn light">
                <i class="bi bi-arrow-left me-1"></i> Back to Learners
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Personal Details</h5>
                    @if ($learner->is_active)
                        <span class="badge bg-success-subtle text-success border border-success-subtle">Active</span>
                    @else
                        <span class="badge bg-secondary-subtle text-secondary border">Inactive</span>
                    @endif
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="text-muted small">Phone</div>
                        <div class="fw-semibold">{{ $learner->phone ?: '—' }}</div>
                    </div>
                    <div class="mb-3">
                        <div class="text-muted small">Alt Phone</div>
                        <div class="fw-semibold">{{ $learner->alt_phone ?: '—' }}</div>
                    </div>
                    <div class="mb-3">
                        <div class="text-muted small">Education</div>
                        <div class="fw-semibold">{{ $learner->educational_qualification ?: '—' }}</div>
                    </div>
                    <div class="mb-3">
                        <div class="text-muted small">Profession</div>
                        <div class="fw-semibold">{{ $learner->current_profession ?: '—' }}</div>
                    </div>
                    <div class="mb-3">
                        <div class="text-muted small">Address</div>
                        <div>{{ $learner->present_address ?: '—' }}</div>
                    </div>
                    @if ($learner->portfolio_or_github)
                        <div>
                            <div class="text-muted small">Portfolio / GitHub</div>
                            <a href="{{ $learner->portfolio_or_github }}" target="_blank" class="text-primary text-decoration-none">
                                {{ $learner->portfolio_or_github }} <i class="bi bi-box-arrow-up-right small"></i>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Enrolled Courses ({{ $learner->enrollments->count() }})</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>COURSE</th>
                                    <th>BATCH</th>
                                    <th>ENROLLED AT</th>
                                    <th>PROGRESS</th>
                                    <th>STATUS</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($learner->enrollments as $enrollment)
                                    <tr>
                                        <td>
                                            <strong>{{ $enrollment->course?->title ?? 'Deleted Course' }}</strong>
                                        </td>
                                        <td>{{ $enrollment->batch_no ?: '—' }}</td>
                                        <td>{{ $enrollment->enrolled_at?->format('d M Y') }}</td>
                                        <td>{{ $enrollment->progress_percent }}%</td>
                                        <td>
                                            <span class="{{ $enrollment->status->badgeClass() }}">
                                                <i class="bi {{ $enrollment->status->icon() }} me-1"></i>
                                                {{ $enrollment->status->label() }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4 text-muted">No course enrollments found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
