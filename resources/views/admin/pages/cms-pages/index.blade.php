@extends('admin.layouts.admin-master')

@section('title', 'Pages Management')

@section('content')
    <div class="heading">
        <div>
            <small>AGENCY ADMIN</small>
            <h1>Website Pages</h1>
            <p>Manage your CMS pages.</p>
        </div>
        <div>
            @can('create-pages')
                <a href="{{ route('admin.pages.create') }}" class="btn primary">
                    <i class="bi bi-plus-lg me-1"></i> Add Page
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
                        <th>PAGE</th>
                        <th>URL SLUG</th>
                        <th>STATUS</th>
                        <th>TEMPLATE</th>
                        <th>UPDATED</th>
                        <th class="text-end-align">ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pages as $page)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    @if ($page->featured_image)
                                        <img src="{{ Str::startsWith($page->featured_image, ['http://', 'https://']) ? $page->featured_image : Storage::url($page->featured_image) }}"
                                            alt="Cover" class="rounded"
                                            style="width: 48px; height: 48px; object-fit: cover;">
                                    @else
                                        <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                            style="width: 48px; height: 48px;">
                                            <i class="bi bi-image text-muted"></i>
                                        </div>
                                    @endif
                                    <span class="fw-semibold text-dark">{{ $page->title }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="text-muted">/{{ $page->slug }}</span>
                            </td>
                            <td>
                                @if ($page->status->value === 'published')
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
                                <span class="text-muted">{{ $page->template }}</span>
                            </td>
                            <td>
                                <span class="text-muted small">
                                    {{ $page->updated_at ? $page->updated_at->format('M d, Y') : '—' }}
                                </span>
                            </td>
                            <td class="text-end-align nowrap-cell">
                                <div class="table-actions">
                                    @can('view-pages')
                                        <a href="{{ route('admin.pages.show', $page) }}"
                                            class="btn-action btn-action-view btn-action-icon" title="View">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    @endcan

                                    @can('edit-pages')
                                        <a href="{{ route('admin.pages.edit', $page) }}"
                                            class="btn-action btn-action-edit btn-action-icon" title="Edit">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                    @endcan

                                    @can('delete-pages')
                                        <form action="{{ route('admin.pages.destroy', $page) }}" method="POST"
                                            class="d-inline" onsubmit="return confirm('Delete this page?');">
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
                            <td colspan="6" class="text-center text-muted py-5">
                                <div class="py-3">
                                    <i class="bi bi-file-earmark-text text-secondary" style="font-size: 2.5rem;"></i>
                                    <h5 class="mt-2 text-dark">No Pages Found</h5>
                                    <p class="text-muted small">You haven't created any pages yet.</p>
                                    @can('create-pages')
                                        <a href="{{ route('admin.pages.create') }}" class="btn primary btn-sm mt-2">
                                            <i class="bi bi-plus-lg me-1"></i> Add New Page
                                        </a>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            @if ($pages->hasPages())
                <div class="p-3 border-top d-flex justify-content-end">
                    {{ $pages->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
@endsection
