@extends('admin.layouts.admin-master')

@section('title', 'Case Studies Management')

@section('content')
    <div class="heading">
        <div>
            <small>AGENCY ADMIN</small>
            <h1>Case Studies</h1>
            <p>Showcase your agency's successful projects.</p>
        </div>
        <div>
            @can('create-case-studies')
                <a href="{{ route('admin.case-studies.create') }}" class="btn primary">
                    <i class="bi bi-plus-lg me-1"></i> Add Case Study
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

    <div class="card list-card mt-4">
        <div class="tablewrap">
            <table>
                <thead>
                    <tr>
                        <th>CASE STUDY</th>
                        <th>PROJECT</th>
                        <th>STATUS</th>
                        <th>PUBLISHED AT</th>
                        <th class="text-end-align">ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($caseStudies as $study)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    @if ($study->featured_image)
                                        <img src="{{ Str::startsWith($study->featured_image, ['http://', 'https://']) ? $study->featured_image : Storage::url($study->featured_image) }}"
                                            alt="Cover" class="rounded"
                                            style="width: 48px; height: 48px; object-fit: cover;">
                                    @else
                                        <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                            style="width: 48px; height: 48px;">
                                            <i class="bi bi-image text-muted"></i>
                                        </div>
                                    @endif
                                    <span class="fw-semibold text-dark">{{ $study->title }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="text-muted">{{ $study->project?->title ?? '—' }}</span>
                            </td>
                            <td>
                                @if ($study->status->value === 'published')
                                    <span class="status-badge status-won">
                                        <i class="bi bi-check-circle-fill me-1"></i> Published
                                    </span>
                                @else
                                    <span class="status-badge status-lost">
                                        <i class="bi bi-journal-x me-1"></i> Draft
                                    </span>
                                @endif
                            </td>
                            <td>
                                <span class="text-muted small">
                                    {{ $study->published_at ? $study->published_at->format('M d, Y') : '—' }}
                                </span>
                            </td>
                            <td class="text-end-align nowrap-cell">
                                <div class="table-actions">
                                    @can('view-case-studies')
                                        <a href="{{ route('admin.case-studies.show', $study) }}"
                                            class="btn-action btn-action-view btn-action-icon" title="View">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    @endcan

                                    @can('edit-case-studies')
                                        <a href="{{ route('admin.case-studies.edit', $study) }}"
                                            class="btn-action btn-action-edit btn-action-icon" title="Edit">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                    @endcan

                                    @can('delete-case-studies')
                                        <form action="{{ route('admin.case-studies.destroy', $study) }}" method="POST"
                                            class="d-inline" onsubmit="return confirm('Delete this case study?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-action btn-action-delete btn-action-icon"
                                                title="Delete">
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
                                    <i class="bi bi-briefcase text-secondary" style="font-size: 2.5rem;"></i>
                                    <h5 class="mt-2 text-dark">No Case Studies Found</h5>
                                    <p class="text-muted small">You haven't created any case studies yet.</p>
                                    @can('create-case-studies')
                                        <a href="{{ route('admin.case-studies.create') }}" class="btn primary btn-sm mt-2">
                                            <i class="bi bi-plus-lg me-1"></i> Add New Case Study
                                        </a>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            @if ($caseStudies->hasPages())
                <div class="p-3 border-top d-flex justify-content-end">
                    {{ $caseStudies->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
@endsection
