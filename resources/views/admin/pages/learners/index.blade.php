@extends('admin.layouts.admin-master')

@section('title', 'Learners Directory')

@section('content')
    <div class="heading">
        <div>
            <small>ACADEMY MODULE</small>
            <h1>Learners Directory</h1>
            <p>Manage enrolled students, learner accounts, and course participation.</p>
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
            <form method="GET" action="{{ route('admin.learners.index') }}" class="toolbar-filters">
                <input type="text" name="search" value="{{ $currentSearch ?? '' }}"
                    placeholder="Search learner code, name, email, phone..." class="filter-search-input">

                <select name="is_active" onchange="this.form.submit()" class="filter-select">
                    <option value="">All Status</option>
                    <option value="1" {{ ($currentActive ?? '') === '1' ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ ($currentActive ?? '') === '0' ? 'selected' : '' }}>Inactive</option>
                </select>

                <button type="submit" class="btn light">Filter</button>
                @if (!empty($currentSearch) || ($currentActive ?? '') !== '')
                    <a href="{{ route('admin.learners.index') }}" class="btn light filter-btn-reset">Reset</a>
                @endif
            </form>
        </div>

        <div class="tablewrap">
            <table>
                <thead>
                    <tr>
                        <th>LEARNER CODE & NAME</th>
                        <th>CONTACT</th>
                        <th>EDUCATION / PROFESSION</th>
                        <th>ENROLLED COURSES</th>
                        <th>STATUS</th>
                        <th class="text-end-align">ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($learners ?? [] as $learner)
                        <tr>
                            <td>
                                <span class="badge bg-light text-dark border mb-1">{{ $learner->learner_code }}</span>
                                <div><strong class="category-name-text">{{ $learner->name }}</strong></div>
                                @if ($learner->user)
                                    <div class="text-muted small">Role: <code>learner</code></div>
                                @endif
                            </td>
                            <td>
                                <div>{{ $learner->phone ?? '—' }}</div>
                                <div class="text-muted small">{{ $learner->email }}</div>
                            </td>
                            <td>
                                <div>{{ $learner->educational_qualification ?? '—' }}</div>
                                <div class="text-muted small">{{ $learner->current_profession ?? '' }}</div>
                            </td>
                            <td>
                                <span class="badge bg-primary-subtle text-primary border border-primary-subtle">
                                    {{ $learner->enrollments_count ?? 0 }} {{ Str::plural('course', $learner->enrollments_count ?? 0) }}
                                </span>
                            </td>
                            <td>
                                @if ($learner->is_active)
                                    <span class="badge bg-success-subtle text-success border border-success-subtle">Active</span>
                                @else
                                    <span class="badge bg-secondary-subtle text-secondary border">Inactive</span>
                                @endif
                            </td>
                            <td class="text-end-align">
                                <div class="d-inline-flex gap-1">
                                    <a href="{{ route('admin.learners.show', $learner) }}" class="btn light icon-btn text-primary" title="View Profile">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    @can('edit-learners')
                                        <form action="{{ route('admin.learners.toggle-status', $learner) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn light icon-btn" title="Toggle Active Status">
                                                <i class="bi {{ $learner->is_active ? 'bi-pause-circle text-warning' : 'bi-play-circle text-success' }}"></i>
                                            </button>
                                        </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">No learners enrolled yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if (isset($learners) && $learners->hasPages())
            <div class="p-3">{{ $learners->links() }}</div>
        @endif
    </div>
@endsection
