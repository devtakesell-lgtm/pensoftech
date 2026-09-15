@extends('admin.layouts.admin-master')

@section('title', 'Project Management')

@section('content')
    {{-- Page Header --}}
    <div class="heading">
        <div>
            <small>AGENCY ADMIN</small>
            <h1>Project Management</h1>
            <p>Manage your PenSoftTech agency operations and track active projects from one place.</p>
        </div>
        <div>
            @can('create-projects')
                <a href="{{ route('admin.projects.create') }}" class="btn primary">
                    <i class="bi bi-plus-lg me-1"></i> Add Project
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

    {{-- Pipeline KPI Cards --}}
    <div class="lead-stats-grid">
        <div class="lead-stat-card">
            <div class="lead-stat-icon icon-primary">
                <i class="bi bi-briefcase-fill"></i>
            </div>
            <div class="lead-stat-content">
                <h4>{{ number_format($totalCount) }}</h4>
                <span>Total Projects</span>
            </div>
        </div>

        <div class="lead-stat-card">
            <div class="lead-stat-icon icon-info">
                <i class="bi bi-calendar-event"></i>
            </div>
            <div class="lead-stat-content">
                <h4>{{ number_format($upcomingCount) }}</h4>
                <span>Upcoming</span>
            </div>
        </div>

        <div class="lead-stat-card">
            <div class="lead-stat-icon icon-warning">
                <i class="bi bi-arrow-repeat"></i>
            </div>
            <div class="lead-stat-content">
                <h4>{{ number_format($ongoingCount) }}</h4>
                <span>Ongoing</span>
            </div>
        </div>

        <div class="lead-stat-card">
            <div class="lead-stat-icon icon-success">
                <i class="bi bi-check2-circle"></i>
            </div>
            <div class="lead-stat-content">
                <h4>{{ number_format($completedCount) }}</h4>
                <span>Completed</span>
            </div>
        </div>
    </div>

    {{-- Projects Table Card --}}
    <div class="card list-card">
        {{-- Search & Filters --}}
        <div class="toolbar">
            <form method="GET" action="{{ route('admin.projects.index') }}" class="toolbar-filters flex-wrap">
                <input type="text" name="search" value="{{ $currentSearch ?? '' }}"
                    placeholder="Search title, client..." class="filter-search-input">

                <select name="status" onchange="this.form.submit()" class="filter-select">
                    <option value="">All Statuses</option>
                    @foreach ($statuses ?? [] as $status)
                        <option value="{{ $status->value }}"
                            {{ ($currentStatus ?? '') === $status->value ? 'selected' : '' }}>
                            {{ $status->label() }}
                        </option>
                    @endforeach
                </select>

                <select name="industry_id" onchange="this.form.submit()" class="filter-select">
                    <option value="">All Industries</option>
                    @foreach ($industries ?? [] as $industry)
                        <option value="{{ $industry->id }}"
                            {{ (string) ($currentIndustry ?? '') === (string) $industry->id ? 'selected' : '' }}>
                            {{ $industry->name }}
                        </option>
                    @endforeach
                </select>

                <button type="submit" class="btn light">Filter</button>

                @if (!empty($currentSearch) || !empty($currentStatus) || !empty($currentIndustry))
                    <a href="{{ route('admin.projects.index') }}" class="btn light filter-btn-reset">
                        Reset
                    </a>
                @endif
            </form>
        </div>

        <div class="tablewrap">
            <table>
                <thead>
                    <tr>
                        <th class="col-lead-contact">PROJECT / CLIENT</th>
                        <th>SERVICES</th>
                        <th>STATUS</th>
                        <th>START DATE</th>
                        <th class="text-end-align">ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($projects ?? [] as $project)
                        @php
                            $initials = collect(explode(' ', $project->title))
                                ->map(fn($w) => mb_substr($w, 0, 1))
                                ->take(2)
                                ->join('');
                        @endphp
                        <tr>
                            <td>
                                <div class="lead-cell-contact">
                                    <div class="lead-avatar-circle"
                                        @if ($project->featured_image) style="background-image: url('{{ Storage::url($project->featured_image) }}'); background-size: cover; background-position: center; color: transparent;" @endif>
                                        {{ strtoupper($initials ?: 'P') }}
                                    </div>
                                    <div class="lead-name-box">
                                        <div class="d-inline-flex align-items-center gap-1">
                                            <a href="{{ route('admin.projects.show', $project) }}"
                                                class="text-decoration-none">
                                                <strong>{{ $project->title }}</strong>
                                            </a>
                                            @if ($project->is_featured)
                                                <x-verified-badge title="Featured Project" />
                                            @endif
                                        </div>
                                        @if ($project->client)
                                            <span class="lead-company">
                                                <i
                                                    class="bi bi-building me-1"></i>{{ $project->client->company_name ?? $project->client->contact_person }}
                                            </span>
                                        @else
                                            <span class="text-muted small">No Client Attached</span>
                                        @endif
                                        <div class="lead-contact-meta">
                                            @if ($project->project_url)
                                                <a href="{{ $project->project_url }}" target="_blank"
                                                    class="lead-contact-item" title="Project Link">
                                                    <i class="bi bi-link-45deg"></i>
                                                    <span class="lead-contact-text">View Site</span>
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="lead-services-wrap">
                                    @forelse($project->services as $service)
                                        <span class="lead-service-tag">{{ $service->name }}</span>
                                    @empty
                                        <span class="text-muted small">No Services</span>
                                    @endforelse
                                </div>
                            </td>
                            <td>
                                @if (auth()->user()->can('edit-projects') && $project->status !== \App\Enums\ProjectStatus::Completed)
                                    <form action="{{ route('admin.projects.update-status', $project) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" onchange="this.form.submit()" class="lead-status-select">
                                            @foreach ($statuses ?? [] as $statusOption)
                                                <option value="{{ $statusOption->value }}"
                                                    {{ $project->status->value === $statusOption->value ? 'selected' : '' }}>
                                                    {{ $statusOption->label() }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </form>
                                @else
                                    <span class="status-badge {{ $project->status->badgeClass() }}">
                                        <i class="bi {{ $project->status->icon() }} me-1"></i>
                                        {{ $project->status->label() }}
                                    </span>
                                @endif
                            </td>
                            <td>
                                @if ($project->start_date)
                                    <span class="fw-semibold text-dark small d-block">
                                        {{ $project->start_date->format('M d, Y') }}
                                    </span>
                                @else
                                    <span class="text-muted small">—</span>
                                @endif
                            </td>
                            <td class="text-end-align nowrap-cell">
                                <div class="table-actions">
                                    @can('view-projects')
                                        <a href="{{ route('admin.projects.show', $project) }}"
                                            class="btn-action btn-action-view btn-action-icon" title="View Project Dossier">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    @endcan

                                    @can('edit-projects')
                                        <a href="{{ route('admin.projects.edit', $project) }}"
                                            class="btn-action btn-action-edit btn-action-icon" title="Edit Project">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                    @endcan

                                    @can('delete-projects')
                                        <form action="{{ route('admin.projects.destroy', $project) }}" method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Are you sure you want to delete project \'{{ $project->title }}\'?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-action btn-action-delete btn-action-icon"
                                                title="Delete Project">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                        </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-5">
                                <div class="py-3">
                                    <i class="bi bi-briefcase text-secondary" style="font-size: 2.5rem;"></i>
                                    <h5 class="mt-2 text-dark">No Projects Found</h5>
                                    <p class="text-muted small">No projects match your filter parameters.
                                    </p>
                                    @can('create-projects')
                                        <a href="{{ route('admin.projects.create') }}" class="btn primary btn-sm mt-2">
                                            <i class="bi bi-plus-lg me-1"></i> Add New Project
                                        </a>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($projects->hasPages())
            <div class="p-3 border-top d-flex justify-content-end">
                {{ $projects->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
@endsection
