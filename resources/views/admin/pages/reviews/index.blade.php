@extends('admin.layouts.admin-master')

@section('title', 'Reviews & Testimonials Management')

@section('content')
    {{-- Page Header --}}
    <div class="heading">
        <div>
            <small>AGENCY ADMIN</small>
            <h1>Reviews & Testimonials</h1>
            <p>Manage customer feedback and testimonials displayed on your website.</p>
        </div>
        <div>
            @can('create-reviews')
                <a href="{{ route('admin.reviews.create') }}" class="btn primary">
                    <i class="bi bi-plus-lg me-1"></i> Add Review
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
                <i class="bi bi-chat-square-quote-fill"></i>
            </div>
            <div class="lead-stat-content">
                <h4>{{ number_format($totalCount) }}</h4>
                <span>Total Reviews</span>
            </div>
        </div>

        <div class="lead-stat-card">
            <div class="lead-stat-icon icon-success">
                <i class="bi bi-check-circle-fill"></i>
            </div>
            <div class="lead-stat-content">
                <h4>{{ number_format($activeCount) }}</h4>
                <span>Active Reviews</span>
            </div>
        </div>

        <div class="lead-stat-card">
            <div class="lead-stat-icon icon-warning">
                <i class="bi bi-star-fill text-warning"></i>
            </div>
            <div class="lead-stat-content">
                <h4>{{ $averageRating }} / 5</h4>
                <span>Average Rating</span>
            </div>
        </div>
    </div>

    {{-- Reviews Table Card --}}
    <div class="card list-card">
        {{-- Search & Filters --}}
        <div class="toolbar">
            <form method="GET" action="{{ route('admin.reviews.index') }}" class="toolbar-filters flex-wrap">
                <input type="text" name="search" value="{{ $currentSearch ?? '' }}"
                    placeholder="Search client name, title, or review text..." class="filter-search-input">

                <select name="status" onchange="this.form.submit()" class="filter-select">
                    <option value="">All Statuses</option>
                    <option value="active" {{ ($currentStatus ?? '') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ ($currentStatus ?? '') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>

                <button type="submit" class="btn light">Filter</button>

                @if (!empty($currentSearch) || !empty($currentStatus))
                    <a href="{{ route('admin.reviews.index') }}" class="btn light filter-btn-reset">
                        Reset
                    </a>
                @endif
            </form>
        </div>

        <div class="tablewrap">
            <table>
                <thead>
                    <tr>
                        <th>CLIENT</th>
                        <th>POSITION / COMPANY</th>
                        <th>RATING</th>
                        <th>REVIEW CONTENT</th>
                        <th>STATUS</th>
                        <th class="text-end-align">ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reviews as $review)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <img src="{{ $review->avatar_url }}" alt="{{ $review->name }}"
                                        class="rounded-circle border" style="width: 38px; height: 38px; object-fit: cover;">
                                    <div>
                                        <span class="fw-semibold text-dark d-block">{{ $review->name }}</span>
                                        <small class="text-muted">Order: {{ $review->sort_order }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="text-secondary">{{ $review->title }}</span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-1">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= $review->rating)
                                            <i class="bi bi-star-fill text-warning" style="font-size: 0.85rem;"></i>
                                        @else
                                            <i class="bi bi-star text-muted opacity-50" style="font-size: 0.85rem;"></i>
                                        @endif
                                    @endfor
                                    <span class="ms-1 small text-muted">({{ $review->rating }})</span>
                                </div>
                            </td>
                            <td>
                                <span class="text-muted small">
                                    {{ \Illuminate\Support\Str::limit($review->content, 70) }}
                                </span>
                            </td>
                            <td>
                                @if ($review->is_active)
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
                                    @can('edit-reviews')
                                        <a href="{{ route('admin.reviews.edit', $review) }}"
                                            class="btn-action btn-action-edit btn-action-icon" title="Edit Review">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                    @endcan

                                    @can('delete-reviews')
                                        <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Are you sure you want to delete this review by \'{{ addslashes($review->name) }}\'?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-action btn-action-delete btn-action-icon"
                                                title="Delete Review">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                        </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-5">
                                <div class="py-3">
                                    <i class="bi bi-chat-square-quote text-secondary" style="font-size: 2.5rem;"></i>
                                    <h5 class="mt-2 text-dark">No Reviews Found</h5>
                                    <p class="text-muted small">No reviews match your search criteria or none have been
                                        added yet.</p>
                                    @can('create-reviews')
                                        <a href="{{ route('admin.reviews.create') }}" class="btn primary btn-sm mt-2">
                                            <i class="bi bi-plus-lg me-1"></i> Add New Review
                                        </a>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($reviews->hasPages())
            <div class="p-3 border-top d-flex justify-content-end">
                {{ $reviews->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
@endsection
