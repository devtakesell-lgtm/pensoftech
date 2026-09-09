@extends('admin.layouts.admin-master')

@section('title', 'Service Categories Management')

@section('content')
    <div class="heading">
        <div>
            <small>SERVICES MODULE</small>
            <h1>Service Categories</h1>
            <p>Organize services into parent categories, manage icons, images, and front-facing visibility.</p>
        </div>
        <div>
            @can('create-services')
                <a href="{{ route('admin.service-categories.create') }}" class="btn primary">
                    <i class="bi bi-plus-lg me-1"></i> Add Category
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

    {{-- Categories Table Card --}}
    <div class="card list-card">
        <div class="toolbar">
            <form method="GET" action="{{ route('admin.service-categories.index') }}" class="toolbar-filters">
                <input type="text" name="search" value="{{ $currentSearch ?? '' }}"
                    placeholder="Search by category name, slug, or keyword..." class="filter-search-input">

                <select name="status" onchange="this.form.submit()" class="filter-select">
                    <option value="">All Status</option>
                    <option value="active" {{ ($currentStatus ?? '') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ ($currentStatus ?? '') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>

                <button type="submit" class="btn light">Filter</button>
                @if (!empty($currentSearch) || !empty($currentStatus))
                    <a href="{{ route('admin.service-categories.index') }}" class="btn light filter-btn-reset">
                        Reset
                    </a>
                @endif
            </form>
        </div>

        <div class="tablewrap">
            <table>
                <thead>
                    <tr>
                        <th>CATEGORY</th>
                        <th>DESCRIPTION</th>
                        <th>SERVICES</th>
                        <th>SORT</th>
                        <th>STATUS</th>
                        <th class="text-end-align">ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories ?? [] as $category)
                        <tr>
                            <td>
                                <div class="category-table-cell">
                                    <div class="category-thumb-box">
                                        @if($category->image)
                                            <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}">
                                        @elseif($category->icon)
                                            <i class="bi {{ $category->icon }}"></i>
                                        @else
                                            <i class="bi bi-folder2-open"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <strong class="category-name-text">{{ $category->name }}</strong>
                                        <span class="category-slug-text">/{{ $category->slug }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="text-muted small">
                                    {{ Str::limit($category->short_description ?? 'No description provided', 55) }}
                                </span>
                            </td>
                            <td>
                                <span class="category-count-badge">
                                    <i class="bi bi-layers-half"></i>
                                    {{ $category->services_count ?? 0 }} {{ Str::plural('service', $category->services_count ?? 0) }}
                                </span>
                            </td>
                            <td>
                                <span class="text-secondary fw-semibold">{{ $category->sort_order }}</span>
                            </td>
                            <td>
                                @if($category->is_active)
                                    <span class="badge status category-status-active">
                                        <i class="bi bi-check2-circle me-1"></i> Active
                                    </span>
                                @else
                                    <span class="badge status category-status-inactive">
                                        <i class="bi bi-pause-circle me-1"></i> Inactive
                                    </span>
                                @endif
                            </td>
                            <td class="text-end-align">
                                <div class="table-actions">
                                    @can('edit-services')
                                        <a href="{{ route('admin.service-categories.edit', $category) }}" 
                                           class="btn-action btn-action-edit" 
                                           title="Edit Category">
                                            <i class="bi bi-pencil-square"></i>
                                            <span>Edit</span>
                                        </a>
                                    @endcan

                                    @can('delete-services')
                                        <form method="POST" action="{{ route('admin.service-categories.destroy', $category) }}" 
                                              onsubmit="return confirm('Are you sure you want to delete category \'{{ addslashes($category->name) }}\'?');" 
                                              class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-action btn-action-delete btn-action-icon" title="Delete Category">
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
                                        <i class="bi bi-folder-x display-6 text-muted"></i>
                                    </div>
                                    <h5 class="fw-bold mb-1">No service categories found</h5>
                                    <p class="text-muted small mb-3">
                                        @if(!empty($currentSearch) || !empty($currentStatus))
                                            No categories match your active filters. Try clearing your search parameters.
                                        @else
                                            Get started by adding your first service category.
                                        @endif
                                    </p>
                                    @can('create-services')
                                        <a href="{{ route('admin.service-categories.create') }}" class="btn primary btn-sm">
                                            <i class="bi bi-plus-lg me-1"></i> Add Category
                                        </a>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
