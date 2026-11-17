@extends('admin.layouts.admin-master')

@section('title', 'Industries Management')

@section('content')
    {{-- Page Header --}}
    <div class="heading">
        <div>
            <small>AGENCY ADMIN</small>
            <h1>Industries Management</h1>
            <p>Manage the business industries your agency serves.</p>
        </div>
        <div>
            @can('create-industries')
                <a href="{{ route('admin.industries.create') }}" class="btn primary">
                    <i class="bi bi-plus-lg me-1"></i> Add Industry
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

    {{-- KPI Cards --}}
    <div class="lead-stats-grid">
        <div class="lead-stat-card">
            <div class="lead-stat-icon icon-primary">
                <i class="bi bi-tags-fill"></i>
            </div>
            <div class="lead-stat-content">
                <h4>{{ number_format($totalCount) }}</h4>
                <span>Total Industries</span>
            </div>
        </div>

        <div class="lead-stat-card">
            <div class="lead-stat-icon icon-success">
                <i class="bi bi-check-circle-fill"></i>
            </div>
            <div class="lead-stat-content">
                <h4>{{ number_format($activeCount) }}</h4>
                <span>Active Industries</span>
            </div>
        </div>
    </div>

    {{-- Industries Table Card --}}
    <div class="card list-card">
        {{-- Search & Filters --}}
        <div class="toolbar">
            <form method="GET" action="{{ route('admin.industries') }}" class="toolbar-filters flex-wrap">
                <input type="text" name="search" value="{{ $currentSearch ?? '' }}"
                    placeholder="Search industries..." class="filter-search-input">

                <select name="status" onchange="this.form.submit()" class="filter-select">
                    <option value="">All Statuses</option>
                    <option value="active" {{ ($currentStatus ?? '') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ ($currentStatus ?? '') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>

                <button type="submit" class="btn light">Filter</button>

                @if (!empty($currentSearch) || !empty($currentStatus))
                    <a href="{{ route('admin.industries') }}" class="btn light filter-btn-reset">
                        Reset
                    </a>
                @endif
            </form>
        </div>

        <div class="tablewrap">
            <table>
                <thead>
                    <tr>
                        <th>INDUSTRY</th>
                        <th>SHORT DESCRIPTION</th>
                        <th>PROJECTS</th>
                        <th>STATUS</th>
                        <th class="text-end-align">ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($industries as $industry)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    @if($industry->icon)
                                        <i class="bi {{ $industry->icon }} text-secondary fs-5"></i>
                                    @endif
                                    <span class="fw-semibold text-dark">{{ $industry->name }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="text-muted small">
                                    {{ \Illuminate\Support\Str::limit($industry->short_description, 60) ?: '—' }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-secondary rounded-pill px-2 py-1">{{ $industry->projects_count ?? 0 }}</span>
                            </td>
                            <td>
                                @if($industry->is_active)
                                    <span class="status-badge status-won">
                                        <i class="bi bi-check-circle-fill me-1"></i> Active
                                    </span>
                                @else
                                    <span class="status-badge status-lost">
                                        <i class="bi bi-x-circle-fill me-1"></i> Inactive
                                    </span>
                                @endif
                            </td>
                            <td class="text-end-align nowrap-cell">
                                <div class="table-actions">
                                    @can('edit-industries')
                                        <a href="{{ route('admin.industries.edit', $industry) }}"
                                            class="btn-action btn-action-edit btn-action-icon" title="Edit Industry">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                    @endcan

                                    @can('delete-industries')
                                        <form action="{{ route('admin.industries.destroy', $industry) }}" method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Are you sure you want to delete industry \'{{ $industry->name }}\'?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-action btn-action-delete btn-action-icon"
                                                title="Delete Industry">
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
                                    <i class="bi bi-tags text-secondary" style="font-size: 2.5rem;"></i>
                                    <h5 class="mt-2 text-dark">No Industries Found</h5>
                                    <p class="text-muted small">No industries match your search criteria.</p>
                                    @can('create-industries')
                                        <a href="{{ route('admin.industries.create') }}" class="btn primary btn-sm mt-2">
                                            <i class="bi bi-plus-lg me-1"></i> Add New Industry
                                        </a>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($industries->hasPages())
            <div class="p-3 border-top d-flex justify-content-end">
                {{ $industries->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
@endsection
