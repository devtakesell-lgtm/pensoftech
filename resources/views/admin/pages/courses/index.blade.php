@extends('admin.layouts.admin-master')

@section('title', 'Courses Management')

@section('content')
    <div class="heading">
        <div>
            <small>ACADEMY MODULE</small>
            <h1>Courses Management</h1>
            <p>Manage office live bootcamps, online sessions, curricula, and admissions.</p>
        </div>
        <div>
            @can('create-courses')
                <a href="{{ route('admin.courses.create') }}" class="btn primary">
                    <i class="bi bi-plus-lg me-1"></i> Add New Course
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
            <form method="GET" action="{{ route('admin.courses.index') }}" class="toolbar-filters">
                <input type="text" name="search" value="{{ $currentSearch ?? '' }}"
                    placeholder="Search by title, batch, venue..." class="filter-search-input">

                <select name="category_id" onchange="this.form.submit()" class="filter-select">
                    <option value="">All Categories</option>
                    @foreach ($categories ?? [] as $cat)
                        <option value="{{ $cat->id }}" {{ (string) ($currentCategory ?? '') === (string) $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>

                <select name="delivery_mode" onchange="this.form.submit()" class="filter-select">
                    <option value="">All Delivery Modes</option>
                    @foreach ($deliveryModes ?? [] as $mode)
                        <option value="{{ $mode->value }}" {{ ($currentMode ?? '') === $mode->value ? 'selected' : '' }}>
                            {{ $mode->label() }}
                        </option>
                    @endforeach
                </select>

                <select name="status" onchange="this.form.submit()" class="filter-select">
                    <option value="">All Statuses</option>
                    @foreach ($statuses ?? [] as $st)
                        <option value="{{ $st->value }}" {{ ($currentStatus ?? '') === $st->value ? 'selected' : '' }}>
                            {{ $st->label() }}
                        </option>
                    @endforeach
                </select>

                <button type="submit" class="btn light">Filter</button>
                @if (!empty($currentSearch) || !empty($currentCategory) || !empty($currentMode) || !empty($currentStatus))
                    <a href="{{ route('admin.courses.index') }}" class="btn light filter-btn-reset">
                        Reset
                    </a>
                @endif
            </form>
        </div>

        <div class="tablewrap">
            <table>
                <thead>
                    <tr>
                        <th>COURSE TITLE & BATCH</th>
                        <th>CATEGORY</th>
                        <th>INSTRUCTOR</th>
                        <th>PRICING</th>
                        <th>SEATS & SCHEDULE</th>
                        <th>STATUS</th>
                        <th class="text-end-align">ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($courses ?? [] as $course)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    @if ($course->thumbnail)
                                        <img src="{{ $course->thumbnail }}" alt="{{ $course->title }}"
                                            style="width: 44px; height: 32px; object-fit: cover; border-radius: 4px;">
                                    @else
                                        <div style="width: 44px; height: 32px; border-radius: 4px; background: #f1f5f9; display: flex; align-items: center; justify-content: center; color: #94a3b8;">
                                            <i class="bi bi-image"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <strong class="category-name-text">{{ $course->title }}</strong>
                                        <div class="d-flex align-items-center gap-1 mt-1">
                                            @if ($course->batch_no)
                                                <span class="badge bg-secondary-subtle text-secondary border small">{{ $course->batch_no }}</span>
                                            @endif
                                            <span class="{{ $course->delivery_mode->badgeClass() }} small">
                                                <i class="bi {{ $course->delivery_mode->icon() }} me-1"></i>
                                                {{ $course->delivery_mode->label() }}
                                            </span>
                                            @if ($course->is_featured)
                                                <span class="badge bg-warning-subtle text-warning border small"><i class="bi bi-star-fill"></i></span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span>{{ $course->category?->name ?? 'Uncategorized' }}</span>
                            </td>
                            <td>
                                <span>{{ $course->instructor?->name ?? 'TBA' }}</span>
                            </td>
                            <td>
                                @if ($course->is_free)
                                    <span class="badge bg-success-subtle text-success border border-success-subtle">Free Course</span>
                                @else
                                    <strong>{{ $course->currency?->symbol ?? '৳' }}{{ number_format($course->price, 2) }}</strong>
                                    @if ($course->discount_price)
                                        <div class="text-muted small text-decoration-line-through">
                                            {{ $course->currency?->symbol ?? '৳' }}{{ number_format($course->discount_price, 2) }}
                                        </div>
                                    @endif
                                @endif
                            </td>
                            <td>
                                <div>
                                    <span class="badge bg-info-subtle text-info border small">
                                        <i class="bi bi-people-fill me-1"></i> Max: {{ $course->max_seats ?? 'Unlimited' }}
                                    </span>
                                </div>
                                @if ($course->class_schedule)
                                    <div class="text-muted small mt-1"><i class="bi bi-clock me-1"></i>{{ $course->class_schedule }}</div>
                                @endif
                            </td>
                            <td>
                                <span class="{{ $course->status->badgeClass() }}">
                                    <i class="bi {{ $course->status->icon() }} me-1"></i>
                                    {{ $course->status->label() }}
                                </span>
                            </td>
                            <td class="text-end-align">
                                <div class="d-inline-flex gap-1">
                                    @can('edit-courses')
                                        <a href="{{ route('admin.courses.edit', $course) }}" class="btn light icon-btn" title="Edit Course">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                    @endcan
                                    @can('delete-courses')
                                        <form action="{{ route('admin.courses.destroy', $course) }}" method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this course?');" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn light icon-btn text-danger" title="Delete Course">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">
                                No courses found matching your filter criteria.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(isset($courses) && $courses->hasPages())
            <div class="p-3">
                {{ $courses->links() }}
            </div>
        @endif
    </div>
@endsection
