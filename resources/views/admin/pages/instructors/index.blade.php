@extends('admin.layouts.admin-master')

@section('title', 'Instructors Management')

@section('content')
    <div class="heading">
        <div>
            <small>ACADEMY MODULE</small>
            <h1>Instructors & Mentors</h1>
            <p>Manage trainers, lead engineers, and mentors conducting courses.</p>
        </div>
        <div>
            @can('create-instructors')
                <a href="{{ route('admin.instructors.create') }}" class="btn primary">
                    <i class="bi bi-plus-lg me-1"></i> Add Instructor
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
            <form method="GET" action="{{ route('admin.instructors.index') }}" class="toolbar-filters">
                <input type="text" name="search" value="{{ $currentSearch ?? '' }}"
                    placeholder="Search by instructor name, title..." class="filter-search-input">

                <button type="submit" class="btn light">Filter</button>
                @if (!empty($currentSearch))
                    <a href="{{ route('admin.instructors.index') }}" class="btn light filter-btn-reset">
                        Reset
                    </a>
                @endif
            </form>
        </div>

        <div class="tablewrap">
            <table>
                <thead>
                    <tr>
                        <th>INSTRUCTOR</th>
                        <th>DESIGNATION</th>
                        <th>ASSIGNED COURSES</th>
                        <th>STATUS</th>
                        <th class="text-end-align">ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($instructors ?? [] as $instructor)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    @if ($instructor->avatar_url)
                                        <img src="{{ $instructor->avatar_url }}" alt="{{ $instructor->name }}"
                                            style="width: 38px; height: 38px; object-fit: cover; border-radius: 50%;">
                                    @else
                                        <div class="avatar-placeholder" style="width: 38px; height: 38px; border-radius: 50%; background: #e2e8f0; display: flex; align-items: center; justify-content: center; font-weight: bold; color: #475569;">
                                            {{ strtoupper(substr($instructor->name, 0, 2)) }}
                                        </div>
                                    @endif
                                    <div>
                                        <strong class="category-name-text">{{ $instructor->name }}</strong>
                                        @if ($instructor->user)
                                            <div class="text-muted small">Linked User: {{ $instructor->user->email }}</div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span>{{ $instructor->designation }}</span>
                            </td>
                            <td>
                                <span class="badge bg-secondary-subtle text-secondary border">
                                    <i class="bi bi-mortarboard me-1"></i>
                                    {{ $instructor->courses_count ?? 0 }} {{ Str::plural('course', $instructor->courses_count ?? 0) }}
                                </span>
                            </td>
                            <td>
                                @if ($instructor->is_active)
                                    <span class="badge bg-success-subtle text-success border border-success-subtle">Active</span>
                                @else
                                    <span class="badge bg-secondary-subtle text-secondary border">Inactive</span>
                                @endif
                            </td>
                            <td class="text-end-align">
                                <div class="d-inline-flex gap-1">
                                    @can('edit-instructors')
                                        <a href="{{ route('admin.instructors.edit', $instructor) }}" class="btn light icon-btn" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                    @endcan
                                    @can('delete-instructors')
                                        <form action="{{ route('admin.instructors.destroy', $instructor) }}" method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this instructor?');" class="d-inline">
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
                            <td colspan="5" class="text-center py-4 text-muted">
                                No instructors found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(isset($instructors) && $instructors->hasPages())
            <div class="p-3">
                {{ $instructors->links() }}
            </div>
        @endif
    </div>
@endsection
