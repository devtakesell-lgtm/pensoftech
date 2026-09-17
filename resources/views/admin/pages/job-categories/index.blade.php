@extends('admin.layouts.admin-master')

@section('title', 'Job Categories Management')

@section('content')
    <div class="heading">
        <div>
            <small>CAREERS MODULE</small>
            <h1>Job Categories</h1>
            <p>Organize job listings into parent categories or departments.</p>
        </div>
        <div>
            @can('create-jobs')
                <a href="{{ route('admin.job-categories.create') }}" class="btn primary">
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
            <form method="GET" action="{{ route('admin.job-categories.index') }}" class="toolbar-filters">
                <input type="text" name="search" value="{{ $currentSearch ?? '' }}"
                    placeholder="Search by category name or slug..." class="filter-search-input">

                <button type="submit" class="btn light">Filter</button>
                @if (!empty($currentSearch))
                    <a href="{{ route('admin.job-categories.index') }}" class="btn light filter-btn-reset">
                        Reset
                    </a>
                @endif
            </form>
        </div>

        <div class="tablewrap">
            <table>
                <thead>
                    <tr>
                        <th>CATEGORY NAME</th>
                        <th>SLUG</th>
                        <th>TOTAL JOBS</th>
                        <th>CREATED AT</th>
                        <th class="text-end-align">ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories ?? [] as $category)
                        <tr>
                            <td>
                                <strong class="category-name-text">{{ $category->name }}</strong>
                            </td>
                            <td>
                                <span class="category-slug-text">/{{ $category->slug }}</span>
                            </td>
                            <td>
                                <span class="category-count-badge">
                                    <i class="bi bi-briefcase"></i>
                                    {{ $category->jobs_count ?? 0 }}
                                    {{ Str::plural('job', $category->jobs_count ?? 0) }}
                                </span>
                            </td>
                            <td>
                                <span class="text-muted small">
                                    {{ $category->created_at->format('M d, Y') }}
                                </span>
                            </td>
                            <td class="text-end-align">
                                <div class="table-actions">
                                    @can('edit-jobs')
                                        <a href="{{ route('admin.job-categories.edit', $category) }}"
                                            class="btn-action btn-action-edit" title="Edit Category">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                    @endcan

                                    @can('delete-jobs')
                                        <form method="POST" action="{{ route('admin.job-categories.destroy', $category) }}"
                                            onsubmit="return confirm('Are you sure you want to delete category \'{{ addslashes($category->name) }}\'?');"
                                            class="d-inline">
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
                            <td colspan="5" class="text-center py-5">
                                <div class="empty-state">
                                    <div class="empty-icon-wrap mb-3">
                                        <i class="bi bi-folder-x display-6 text-muted"></i>
                                    </div>
                                    <h5 class="fw-bold mb-1">No job categories found</h5>
                                    <p class="text-muted small mb-3">
                                        @if (!empty($currentSearch))
                                            No categories match your search parameters.
                                        @else
                                            Get started by adding your first job category.
                                        @endif
                                    </p>
                                    @can('create-jobs')
                                        <a href="{{ route('admin.job-categories.create') }}" class="btn primary btn-sm">
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
