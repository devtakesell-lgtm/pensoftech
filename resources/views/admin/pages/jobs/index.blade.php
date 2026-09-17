@extends('admin.layouts.admin-master')

@section('title', 'Jobs Management')

@section('content')
    <div class="heading">
        <div>
            <small>CAREERS MODULE</small>
            <h1>Job Listings</h1>
            <p>Manage open positions, requirements, and publishing status.</p>
        </div>
        <div>
            @can('create-jobs')
                <a href="{{ route('admin.jobs.create') }}" class="btn primary">
                    <i class="bi bi-plus-lg me-1"></i> Post New Job
                </a>
            @endcan
        </div>
    </div>

    {{-- Flash Alerts --}}
    @if (session('success'))
        <div class="alert-custom alert-custom-success">
            <i class="bi bi-check-circle-fill"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if (session('error'))
        <div class="alert-custom alert-custom-danger">
            <i class="bi bi-exclamation-triangle-fill"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    {{-- Jobs Table Card --}}
    <div class="card list-card">
        <div class="toolbar">
            <form method="GET" action="{{ route('admin.jobs.index') }}" class="toolbar-filters">
                <input type="text" name="search" value="{{ $currentSearch ?? '' }}"
                    placeholder="Search by title, location..." class="filter-search-input">

                <select name="status" onchange="this.form.submit()" class="filter-select">
                    <option value="">All Status</option>
                    @foreach ($statuses ?? [] as $status)
                        <option value="{{ $status->value }}"
                            {{ ($currentStatus ?? '') === $status->value ? 'selected' : '' }}>
                            {{ $status->label() }}
                        </option>
                    @endforeach
                </select>

                <button type="submit" class="btn light">Filter</button>
                @if (!empty($currentSearch) || !empty($currentStatus))
                    <a href="{{ route('admin.jobs.index') }}" class="btn light filter-btn-reset">
                        Reset
                    </a>
                @endif
            </form>
        </div>

        <div class="tablewrap">
            <table>
                <thead>
                    <tr>
                        <th>JOB TITLE</th>
                        <th>DEPARTMENT</th>
                        <th>LOCATION</th>
                        <th>VACANCY</th>
                        <th>STATUS</th>
                        <th class="text-end-align">ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jobs ?? [] as $job)
                        <tr>
                            <td>
                                <div>
                                    <strong class="category-name-text">{{ $job->title }}</strong>
                                    @if ($job->employment_type)
                                        <span class="badge light ms-1" style="font-size:0.7em;">
                                            {{ App\Enums\EmploymentType::tryFrom($job->employment_type?->label()) ?? $job->employment_type }}
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <span class="text-muted small">
                                    {{ $job->category ? $job->category->name : 'Uncategorized' }}
                                </span>
                            </td>
                            <td>
                                <span class="text-secondary fw-semibold">
                                    <i class="bi bi-geo-alt me-1"></i>
                                    {{ $job->location ?? 'Remote' }}
                                </span>
                            </td>
                            <td>
                                <span class="category-count-badge">
                                    <i class="bi bi-people"></i>
                                    {{ $job->vacancy }} {{ Str::plural('seat', $job->vacancy) }}
                                </span>
                            </td>
                            <td>
                                @if ($job->status === 'open')
                                    <span class="badge status category-status-active">
                                        <i class="bi bi-check2-circle me-1"></i> Open
                                    </span>
                                @elseif ($job->status === 'draft')
                                    <span class="badge status category-status-inactive">
                                        <i class="bi bi-pencil-square me-1"></i> Draft
                                    </span>
                                @else
                                    <span class="badge status category-status-inactive"
                                        style="background-color: #fee2e2; color: #b91c1c;">
                                        <i class="bi bi-x-circle me-1"></i> Closed
                                    </span>
                                @endif
                            </td>
                            <td class="text-end-align">
                                <div class="table-actions">
                                    @can('edit-jobs')
                                        <a href="{{ route('admin.jobs.edit', $job) }}" class="btn-action btn-action-edit"
                                            title="Edit Job">
                                            <i class="bi bi-pencil-square"></i>
                                            <span>Edit</span>
                                        </a>
                                    @endcan

                                    @can('delete-jobs')
                                        <form method="POST" action="{{ route('admin.jobs.destroy', $job) }}"
                                            onsubmit="return confirm('Are you sure you want to delete job \'{{ addslashes($job->title) }}\'?');"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-action btn-action-delete btn-action-icon"
                                                title="Delete Job">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                        </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="empty-state">
                                    <div class="empty-icon-wrap mb-3">
                                        <i class="bi bi-briefcase display-6 text-muted"></i>
                                    </div>
                                    <h5 class="fw-bold mb-1">No job listings found</h5>
                                    <p class="text-muted small mb-3">
                                        @if (!empty($currentSearch) || !empty($currentStatus))
                                            No jobs match your active filters.
                                        @else
                                            Get started by posting your first job opportunity.
                                        @endif
                                    </p>
                                    @can('create-jobs')
                                        <a href="{{ route('admin.jobs.create') }}" class="btn primary btn-sm">
                                            <i class="bi bi-plus-lg me-1"></i> Post New Job
                                        </a>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($jobs->hasPages())
            <div class="p-3 border-top d-flex justify-content-end">
                {{ $jobs->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
@endsection
