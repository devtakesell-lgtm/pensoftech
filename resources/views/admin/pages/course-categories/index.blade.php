@extends('admin.layouts.admin-master')

@section('title', 'Course Categories')

@section('content')
    <div class="heading">
        <div>
            <small>ACADEMY MODULE</small>
            <h1>Course Categories</h1>
            <p>Manage and organize training courses into distinct tracks and subjects.</p>
        </div>
        <div>
            @can('create-courses')
                <a href="{{ route('admin.course-categories.create') }}" class="btn primary">
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

    <div class="card list-card">
        <div class="toolbar">
            <form method="GET" action="{{ route('admin.course-categories.index') }}" class="toolbar-filters">
                <input type="text" name="search" value="{{ $currentSearch ?? '' }}"
                    placeholder="Search by category name or slug..." class="filter-search-input">

                <button type="submit" class="btn light">Filter</button>
                @if (!empty($currentSearch))
                    <a href="{{ route('admin.course-categories.index') }}" class="btn light filter-btn-reset">
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
                        <th>COURSES</th>
                        <th>STATUS</th>
                        <th>ORDER</th>
                        <th class="text-end-align">ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories ?? [] as $category)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    @if ($category->icon)
                                        <i class="bi {{ $category->icon }} text-primary"></i>
                                    @endif
                                    <strong class="category-name-text">{{ $category->name }}</strong>
                                </div>
                            </td>
                            <td>
                                <span class="category-slug-text">/{{ $category->slug }}</span>
                            </td>
                            <td>
                                <span class="badge bg-secondary-subtle text-secondary border">
                                    <i class="bi bi-journal-code me-1"></i>
                                    {{ $category->courses_count ?? 0 }} {{ Str::plural('course', $category->courses_count ?? 0) }}
                                </span>
                            </td>
                            <td>
                                @if ($category->is_active)
                                    <span class="badge bg-success-subtle text-success border border-success-subtle">Active</span>
                                @else
                                    <span class="badge bg-secondary-subtle text-secondary border">Inactive</span>
                                @endif
                            </td>
                            <td>{{ $category->order }}</td>
                            <td class="text-end-align">
                                <div class="d-inline-flex gap-1">
                                    @can('edit-courses')
                                        <a href="{{ route('admin.course-categories.edit', $category) }}" class="btn light icon-btn" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                    @endcan
                                    @can('delete-courses')
                                        <form action="{{ route('admin.course-categories.destroy', $category) }}" method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this category?');" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn light icon-btn text-danger" title="Delete">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">
                                No course categories found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(isset($categories) && $categories->hasPages())
            <div class="p-3">
                {{ $categories->links() }}
            </div>
        @endif
    </div>
@endsection
