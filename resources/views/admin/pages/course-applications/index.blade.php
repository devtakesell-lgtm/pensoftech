@extends('admin.layouts.admin-master')

@section('title', 'Course Applications & Screening')

@section('content')
    <div class="heading">
        <div>
            <small>ACADEMY MODULE</small>
            <h1>Course Applications</h1>
            <p>Screen applicants, schedule office/online interviews, verify payments, and select students.</p>
        </div>
    </div>

    {{-- Flash Alerts --}}
    @if (session('success'))
        <div class="alert-custom alert-custom-success mb-3">
            <i class="bi bi-check-circle-fill"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if (session('error'))
        <div class="alert-custom alert-custom-danger mb-3">
            <i class="bi bi-exclamation-triangle-fill"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    {{-- Pipeline Status Filter Tabs --}}
    <div class="d-flex flex-wrap gap-2 mb-3">
        <a href="{{ route('admin.course-applications.index', array_filter(['course_id' => $currentCourse, 'search' => $currentSearch])) }}"
            class="btn {{ empty($currentStatus) ? 'primary' : 'light' }} btn-sm ms-0">
            All <span class="badge bg-white text-dark ms-1">{{ $totalApplications ?? 0 }}</span>
        </a>
        @foreach ($statuses as $st)
            <a href="{{ route('admin.course-applications.index', array_filter(['status' => $st->value, 'course_id' => $currentCourse, 'search' => $currentSearch])) }}"
                class="btn {{ ($currentStatus ?? '') === $st->value ? 'primary' : 'light' }} btn-sm ms-0">
                <i class="bi {{ $st->icon() }} me-1"></i> {{ $st->label() }}
                <span class="badge bg-white text-dark ms-1">{{ $statusCounts[$st->value] ?? 0 }}</span>
            </a>
        @endforeach
    </div>

    <div class="card list-card">
        <div class="toolbar">
            <form method="GET" action="{{ route('admin.course-applications.index') }}" class="toolbar-filters">
                <input type="text" name="search" value="{{ $currentSearch ?? '' }}"
                    placeholder="Search app #, name, phone, TrxID..." class="filter-search-input">

                <select name="course_id" onchange="this.form.submit()" class="filter-select">
                    <option value="">All Courses</option>
                    @foreach ($courses ?? [] as $c)
                        <option value="{{ $c->id }}" {{ (string) ($currentCourse ?? '') === (string) $c->id ? 'selected' : '' }}>
                            {{ $c->title }} {{ $c->batch_no ? "({$c->batch_no})" : '' }}
                        </option>
                    @endforeach
                </select>

                <select name="status" onchange="this.form.submit()" class="filter-select">
                    <option value="">All Stages</option>
                    @foreach ($statuses ?? [] as $st)
                        <option value="{{ $st->value }}" {{ ($currentStatus ?? '') === $st->value ? 'selected' : '' }}>
                            {{ $st->label() }}
                        </option>
                    @endforeach
                </select>

                <select name="payment_status" onchange="this.form.submit()" class="filter-select">
                    <option value="">All Payment Statuses</option>
                    @foreach ($paymentStatuses ?? [] as $ps)
                        <option value="{{ $ps->value }}" {{ ($currentPaymentStatus ?? '') === $ps->value ? 'selected' : '' }}>
                            {{ $ps->label() }}
                        </option>
                    @endforeach
                </select>

                <button type="submit" class="btn light">Filter</button>
                @if (!empty($currentSearch) || !empty($currentCourse) || !empty($currentStatus) || !empty($currentPaymentStatus))
                    <a href="{{ route('admin.course-applications.index') }}" class="btn light filter-btn-reset">
                        Reset
                    </a>
                @endif
            </form>
        </div>

        <div class="tablewrap">
            <table>
                <thead>
                    <tr>
                        <th>APP NO & APPLICANT</th>
                        <th>COURSE</th>
                        <th>FEE & PAYMENT</th>
                        <th>INTERVIEW</th>
                        <th>STAGE</th>
                        <th class="text-end-align">ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($applications ?? [] as $app)
                        <tr>
                            <td>
                                <div>
                                    <span class="badge bg-light text-dark border mb-1">{{ $app->application_no }}</span>
                                    <div><strong class="category-name-text">{{ $app->student_name }}</strong></div>
                                    <div class="text-muted small">{{ $app->phone }} • {{ $app->email }}</div>
                                </div>
                            </td>
                            <td>
                                <div>{{ $app->course?->title ?? 'Deleted Course' }}</div>
                                @if ($app->course?->batch_no)
                                    <span class="badge bg-secondary-subtle text-secondary border small">{{ $app->course->batch_no }}</span>
                                @endif
                            </td>
                            <td>
                                @if ($app->course?->is_free || (float) $app->payable_amount === 0.0)
                                    <span class="{{ $app->payment_status->badgeClass() }}">{{ $app->payment_status->label() }}</span>
                                @else
                                    <div>
                                        <strong>{{ $app->currency?->symbol ?? $defaultCurrency?->symbol ?? '৳' }}{{ number_format($app->payable_amount, 2) }}</strong>
                                        <span class="text-muted small">({{ strtoupper($app->payment_method) }})</span>
                                    </div>
                                    @if ($app->transaction_id)
                                        <div class="text-muted small">TrxID: <code>{{ $app->transaction_id }}</code></div>
                                    @endif
                                    <div class="mt-1">
                                        <span class="{{ $app->payment_status->badgeClass() }}">{{ $app->payment_status->label() }}</span>
                                    </div>
                                @endif
                            </td>
                            <td>
                                @if ($app->interview_date)
                                    <div class="small fw-semibold text-primary">
                                        <i class="bi bi-calendar-event me-1"></i>{{ $app->interview_date->format('d M Y') }}
                                        @if ($app->interview_time)
                                            ({{ \Carbon\Carbon::parse($app->interview_time)->format('h:i A') }})
                                        @endif
                                    </div>
                                    @if ($app->interview_venue)
                                        <div class="text-muted small text-truncate" style="max-width: 180px;">{{ $app->interview_venue }}</div>
                                    @endif
                                @else
                                    <span class="text-muted small">Not scheduled</span>
                                @endif
                            </td>
                            <td>
                                <span class="{{ $app->status->badgeClass() }}">
                                    <i class="bi {{ $app->status->icon() }} me-1"></i>
                                    {{ $app->status->label() }}
                                </span>
                            </td>
                            <td class="text-end-align">
                                <div class="d-inline-flex gap-1">
                                    <a href="{{ route('admin.course-applications.show', $app) }}" class="btn light icon-btn text-primary"
                                        title="Review, Screen & Schedule Interview">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    @can('delete-course-applications')
                                        <form action="{{ route('admin.course-applications.destroy', $app) }}" method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this application?');" class="d-inline">
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
                                No course applications found matching your criteria.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if (isset($applications) && $applications->hasPages())
            <div class="p-3">
                {{ $applications->links() }}
            </div>
        @endif
    </div>
@endsection
