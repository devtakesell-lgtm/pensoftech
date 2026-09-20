@extends('admin.layouts.admin-master')

@section('title', 'Blog Categories')

@section('content')
    <div class="heading">
        <div>
            <small>CONTENT ADMIN</small>
            <h1>Blog Categories</h1>
            <p>Organize your articles into high-level content buckets.</p>
        </div>
        <div>
            @can('create-blog-categories')
                <a href="{{ route('admin.blog-categories.create') }}" class="btn primary">
                    <i class="bi bi-plus-lg me-1"></i> Add Category
                </a>
            @endcan
        </div>
    </div>

    @if (session('success'))
        <div class="alert-custom alert-custom-success">
            <i class="bi bi-check-circle-fill"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    {{-- KPI Cards --}}
    <div class="lead-stats-grid mb-4">
        <div class="lead-stat-card">
            <div class="lead-stat-icon icon-primary">
                <i class="bi bi-grid-fill"></i>
            </div>
            <div class="lead-stat-content">
                <h4>{{ number_format($totalCount) }}</h4>
                <span>Total Categories</span>
            </div>
        </div>

        <div class="lead-stat-card">
            <div class="lead-stat-icon icon-success">
                <i class="bi bi-check-circle-fill"></i>
            </div>
            <div class="lead-stat-content">
                <h4>{{ number_format($activeCount) }}</h4>
                <span>Active</span>
            </div>
        </div>

        <div class="lead-stat-card">
            <div class="lead-stat-icon icon-warning">
                <i class="bi bi-x-circle-fill"></i>
            </div>
            <div class="lead-stat-content">
                <h4>{{ number_format($inactiveCount) }}</h4>
                <span>Inactive</span>
            </div>
        </div>
    </div>

    <div class="card list-card">
        {{-- Search & Filters Toolbar --}}
        <div class="toolbar">
            <form method="GET" action="{{ route('admin.blog-categories.index') }}" class="toolbar-filters flex-wrap">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search category name..."
                    class="filter-search-input">

                <select name="status" onchange="this.form.submit()" class="filter-select">
                    <option value="">All Statuses</option>
                    <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Inactive</option>
                </select>

                <button type="submit" class="btn light">Filter</button>

                @if (request('search') || request()->has('status'))
                    <a href="{{ route('admin.blog-categories.index') }}" class="btn light filter-btn-reset">
                        Reset
                    </a>
                @endif
            </form>
        </div>

        <div class="tablewrap">
            <table>
                <thead>
                    <tr>
                        <th class="col-lead-contact">CATEGORY NAME</th>
                        <th>SLUG</th>
                        <th>POSTS COUNT</th>
                        <th>STATUS</th>
                        <th class="text-end-align">ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                        @php
                            $initial = mb_substr($category->name, 0, 1);
                        @endphp
                        <tr>
                            <td>
                                <div class="lead-cell-contact">

                                    <div class="lead-name-box">
                                        <div class="d-inline-flex align-items-center gap-1">
                                            <strong class="text-dark">{{ $category->name }}</strong>
                                        </div>
                                        @if ($category->description)
                                            <div class="lead-contact-meta mt-1">
                                                <span
                                                    class="text-muted small">{{ Str::limit($category->description, 50) }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="font-monospace text-muted small bg-light px-2 py-1 rounded border">
                                    {{ $category->slug }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-secondary text-white rounded-pill px-3 py-2">
                                    {{ $category->blogs_count }} Articles
                                </span>
                            </td>
                            <td>
                                @if ($category->is_active)
                                    <span class="status-badge status-won">
                                        <i class="bi bi-check-circle me-1"></i> Active
                                    </span>
                                @else
                                    <span class="status-badge status-lost">
                                        <i class="bi bi-x-circle me-1"></i> Inactive
                                    </span>
                                @endif
                            </td>
                            <td class="text-end-align nowrap-cell">
                                <div class="table-actions">
                                    @can('edit-blog-categories')
                                        <a href="{{ route('admin.blog-categories.edit', $category) }}"
                                            class="btn-action btn-action-edit btn-action-icon" title="Edit Category">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                    @endcan
                                    @can('delete-blog-categories')
                                        <form action="{{ route('admin.blog-categories.destroy', $category) }}" method="POST"
                                            class="d-inline" onsubmit="return confirm('Delete category?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-action btn-action-delete btn-action-icon"
                                                title="Delete Category">
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
                                    <i class="bi bi-grid text-secondary fs-1"></i>
                                    <h5 class="mt-2 text-dark">No Categories Found</h5>
                                    @can('create-blog-categories')
                                        <a href="{{ route('admin.blog-categories.create') }}" class="btn primary btn-sm mt-2">
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

        @if ($categories->hasPages())
            <div class="p-3 border-top d-flex justify-content-end">
                {{ $categories->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
@endsection
