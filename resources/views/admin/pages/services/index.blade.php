@extends('admin.layouts.admin-master')

@section('title', 'Services Management')

@section('content')
    <div class="heading">
        <div>
            <small>AGENCY ADMIN</small>
            <h1>Services Management</h1>
            <p>Manage all agency service offerings, categories, visual assets, and publication status.</p>
        </div>
        <div>
            @can('create-services')
                <a href="{{ route('admin.services.create') }}" class="btn primary">
                    <i class="bi bi-plus-lg me-1"></i> Add Service
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

    {{-- Services Table Card --}}
    <div class="card list-card">
        <div class="toolbar">
            <form method="GET" action="{{ route('admin.services') }}" class="toolbar-filters">
                <input type="text" name="search" value="{{ $currentSearch ?? '' }}"
                    placeholder="Search by name, slug, or keyword..." class="filter-search-input">

                <select name="category" onchange="this.form.submit()" class="filter-select">
                    <option value="">All Categories</option>
                    @foreach ($categories ?? [] as $category)
                        <option value="{{ $category->id }}"
                            {{ (string) ($currentCategory ?? '') === (string) $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>

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
                @if (!empty($currentSearch) || !empty($currentCategory) || !empty($currentStatus))
                    <a href="{{ route('admin.services') }}" class="btn light filter-btn-reset">
                        Reset
                    </a>
                @endif
            </form>
        </div>

        <div class="tablewrap">
            <table>
                <thead>
                    <tr>
                        <th>SERVICE</th>
                        <th>CATEGORY</th>
                        <th>PROJECTS</th>
                        <th>STATUS</th>
                        <th>SORT</th>
                        <th class="text-end-align">ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($services ?? [] as $service)
                        <tr>
                            <td>
                                <div class="service-table-cell">
                                    <div class="service-thumb-box">
                                        @if ($service->featured_image)
                                            <img src="{{ asset('storage/' . $service->featured_image) }}"
                                                alt="{{ $service->name }}">
                                        @elseif($service->icon)
                                            <i class="bi {{ $service->icon }}"></i>
                                        @else
                                            <i class="bi bi-layers"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <strong class="service-name-text">
                                            {{ $service->name }}
                                            @if ($service->is_featured)
                                                <span class="badge-featured ms-1" title="Featured on website">
                                                    <i class="bi bi-star-fill"></i> Featured
                                                </span>
                                            @endif
                                        </strong>
                                        <small class="service-slug-text">/{{ $service->slug }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="service-cat-badge">
                                    {{ $service->category?->name ?? 'Uncategorized' }}
                                </span>
                            </td>
                            <td>
                                <span class="d-inline-flex align-items-center gap-1 text-secondary fw-semibold">
                                    <i class="bi bi-kanban"></i> {{ $service->projects_count }} projects
                                </span>
                            </td>
                            <td>
                                @if ($service->status->value === 'published')
                                    <span class="status-badge service-status-published">
                                        <span class="status-dot status-dot-active"></span> Published
                                    </span>
                                @elseif($service->status->value === 'draft')
                                    <span class="status-badge service-status-draft">
                                        <span class="status-dot status-dot-inactive"></span> Draft
                                    </span>
                                @else
                                    <span class="status-badge service-status-archived">
                                        <span class="status-dot"></span> Archived
                                    </span>
                                @endif
                            </td>
                            <td>
                                <span class="text-muted fw-semibold">#{{ $service->sort_order }}</span>
                            </td>
                            <td class="text-end-align nowrap-cell">
                                <div class="table-actions">
                                    @can('edit-services')
                                        <a href="{{ route('admin.services.edit', $service) }}"
                                            class="btn-action btn-action-edit" title="Edit Service">
                                            <i class="bi bi-pencil-square"></i>
                                            <span>Edit</span>
                                        </a>
                                    @endcan

                                    @can('delete-services')
                                        <form action="{{ route('admin.services.destroy', $service) }}" method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Are you sure you want to delete service \'{{ $service->name }}\'?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-action btn-action-delete btn-action-icon"
                                                title="Delete Service">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                        </form>
                                    @endcan

                                    @cannot('edit-services')
                                        @cannot('delete-services')
                                            <span class="text-muted">—</span>
                                        @endcannot
                                    @endcannot
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                No service offerings found matching your criteria.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($services->hasPages())
            <div class="p-3 border-top d-flex justify-content-end">
                {{ $services->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
@endsection
