@extends('admin.layouts.admin-master')

@section('title', 'Course Enrollments')

@section('content')
    <div class="heading">
        <div>
            <small>ACADEMY MODULE</small>
            <h1>Course Enrollments</h1>
            <p>Track active learners, batch enrollments, completion progress, and status.</p>
        </div>
    </div>

    @if (session('success'))
        <div class="alert-custom alert-custom-success mb-3">
            <i class="bi bi-check-circle-fill"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="card list-card">
        <div class="toolbar">
            <form method="GET" action="{{ route('admin.course-enrollments.index') }}" class="toolbar-filters">
                <input type="text" name="search" value="{{ $currentSearch ?? '' }}"
                    placeholder="Search learner name, code, phone..." class="filter-search-input">

                <select name="course_id" onchange="this.form.submit()" class="filter-select">
                    <option value="">All Courses</option>
                    @foreach ($courses ?? [] as $c)
                        <option value="{{ $c->id }}" {{ (string) ($currentCourse ?? '') === (string) $c->id ? 'selected' : '' }}>
                            {{ $c->title }} {{ $c->batch_no ? "({$c->batch_no})" : '' }}
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
                @if (!empty($currentSearch) || !empty($currentCourse) || !empty($currentStatus))
                    <a href="{{ route('admin.course-enrollments.index') }}" class="btn light filter-btn-reset">Reset</a>
                @endif
            </form>
        </div>

        <div class="tablewrap">
            <table>
                <thead>
                    <tr>
                        <th>LEARNER</th>
                        <th>COURSE & BATCH</th>
                        <th>ENROLLED AT</th>
                        <th>PROGRESS</th>
                        <th>STATUS</th>
                        <th class="text-end-align">UPDATE STATUS</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($enrollments ?? [] as $enrollment)
                        <tr>
                            <td>
                                @if ($enrollment->learner)
                                    <a href="{{ route('admin.learners.show', $enrollment->learner) }}" class="text-decoration-none">
                                        <span class="badge bg-light text-dark border mb-1">{{ $enrollment->learner->learner_code }}</span>
                                        <div><strong class="category-name-text text-dark">{{ $enrollment->learner->name }}</strong></div>
                                    </a>
                                    <div class="text-muted small">{{ $enrollment->learner->phone }}</div>
                                @else
                                    <span class="text-muted">Unknown Learner</span>
                                @endif
                            </td>
                            <td>
                                <div><strong>{{ $enrollment->course?->title ?? 'Deleted Course' }}</strong></div>
                                @if ($enrollment->batch_no)
                                    <span class="badge bg-secondary-subtle text-secondary border small">{{ $enrollment->batch_no }}</span>
                                @endif
                            </td>
                            <td>
                                <span class="small">{{ $enrollment->enrolled_at?->format('d M Y, h:i A') }}</span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="progress flex-grow-1" style="height: 6px; min-width: 70px;">
                                        <div class="progress-bar bg-primary" style="width: {{ $enrollment->progress_percent }}%;"></div>
                                    </div>
                                    <span class="small fw-semibold">{{ $enrollment->progress_percent }}%</span>
                                </div>
                            </td>
                            <td>
                                <span class="{{ $enrollment->status->badgeClass() }}">
                                    <i class="bi {{ $enrollment->status->icon() }} me-1"></i>
                                    {{ $enrollment->status->label() }}
                                </span>
                            </td>
                            <td class="text-end-align">
                                @can('edit-course-enrollments')
                                    <form action="{{ route('admin.course-enrollments.update-status', $enrollment) }}" method="POST" class="d-inline-flex gap-1">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" onchange="this.form.submit()" class="form-select form-select-sm" style="width: auto;">
                                            @foreach ($statuses as $st)
                                                <option value="{{ $st->value }}" {{ $enrollment->status === $st ? 'selected' : '' }}>
                                                    {{ $st->label() }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </form>
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">No course enrollments found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if (isset($enrollments) && $enrollments->hasPages())
            <div class="p-3">{{ $enrollments->links() }}</div>
        @endif
    </div>
@endsection
