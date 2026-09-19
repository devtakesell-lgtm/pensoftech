@extends('admin.layouts.admin-master')

@section('title', 'Job Applications')

@section('content')
    <div class="heading">
        <div>
            <small>CAREERS MODULE</small>
            <h1>Job Applications</h1>
            <p>Manage candidate applications, view CVs, and update application statuses.</p>
        </div>
    </div>

    {{-- Flash Alerts --}}
    @if (session('success'))
        <div class="alert-custom alert-custom-success">
            <i class="bi bi-check-circle-fill"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="card list-card">
        <div class="tablewrap">
            <table>
                <thead>
                    <tr>
                        <th>CANDIDATE</th>
                        <th>JOB POSTING</th>
                        <th>APPLIED ON</th>
                        <th>STATUS</th>
                        <th class="text-end-align">ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jobApplications ?? [] as $application)
                        <tr>
                            <td>
                                <div>
                                    <strong class="category-name-text">{{ $application->name }}</strong>
                                    <br>
                                    <span class="text-muted small">
                                        <i class="bi bi-envelope"></i> {{ $application->email }}
                                    </span>
                                </div>
                            </td>
                            <td>
                                <span class="text-secondary fw-semibold">
                                    {{ $application->job->title ?? 'Unknown Job' }}
                                </span>
                            </td>
                            <td>
                                <span class="text-muted small">
                                    {{ $application->created_at->format('M d, Y') }}
                                </span>
                            </td>
                            <td>
                                @php
                                    $statusColor = match($application->status->value) {
                                        'applied' => 'bg-secondary',
                                        'shortlisted' => 'bg-primary',
                                        'interviewed' => 'bg-info',
                                        'offered' => 'bg-warning',
                                        'hired' => 'bg-success',
                                        'rejected' => 'bg-danger',
                                        default => 'bg-secondary'
                                    };
                                @endphp
                                <span class="badge {{ $statusColor }}">
                                    {{ $application->status->label() }}
                                </span>
                            </td>
                            <td class="text-end-align">
                                <div class="table-actions">
                                    @can('view-job-applications')
                                        <a href="{{ route('admin.job-applications.show', $application) }}" class="btn-action"
                                            title="View Details">
                                            <i class="bi bi-eye"></i>
                                            <span>View</span>
                                        </a>
                                    @endcan
                                    
                                    @can('edit-job-applications')
                                        <a href="{{ route('admin.job-applications.edit', $application) }}" class="btn-action btn-action-edit"
                                            title="Update Status">
                                            <i class="bi bi-pencil-square"></i>
                                            <span>Status</span>
                                        </a>
                                    @endcan

                                    @can('delete-job-applications')
                                        <form method="POST" action="{{ route('admin.job-applications.destroy', $application) }}"
                                            onsubmit="return confirm('Are you sure you want to delete this application?');"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-action btn-action-delete btn-action-icon"
                                                title="Delete Application">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                        </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div class="empty-state">
                                    <div class="empty-icon-wrap mb-3">
                                        <i class="bi bi-inbox display-6 text-muted"></i>
                                    </div>
                                    <h5 class="fw-bold mb-1">No job applications yet</h5>
                                    <p class="text-muted small mb-3">
                                        Applications submitted by candidates will appear here.
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if (isset($jobApplications) && $jobApplications->hasPages())
            <div class="p-3 border-top d-flex justify-content-end">
                {{ $jobApplications->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
@endsection
