@extends('admin.layouts.admin-master')

@section('title', 'Blog Tags')

@section('content')
    <div class="heading">
        <div>
            <small>CONTENT ADMIN</small>
            <h1>Blog Tags</h1>
            <p>Manage tags used to loosely categorize and cross-reference your articles.</p>
        </div>
        <div>
            @can('create-blog-tags')
                <a href="{{ route('admin.blog-tags.create') }}" class="btn primary">
                    <i class="bi bi-plus-lg me-1"></i> Add Tag
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



    <div class="card list-card">
        {{-- Search & Filters Toolbar --}}
        <div class="toolbar">
            <form method="GET" action="{{ route('admin.blog-tags.index') }}" class="toolbar-filters flex-wrap">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search tag name..."
                    class="filter-search-input">

                <button type="submit" class="btn light">Filter</button>

                @if (request('search') || request()->has('status'))
                    <a href="{{ route('admin.blog-tags.index') }}" class="btn light filter-btn-reset">
                        Reset
                    </a>
                @endif
            </form>
        </div>

        <div class="tablewrap">
            <table>
                <thead>
                    <tr>
                        <th class="col-lead-contact">TAG NAME</th>
                        <th>SLUG</th>
                        <th>POSTS COUNT</th>
                        {{-- <th>STATUS</th> --}}
                        <th class="text-end-align">ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tags as $tag)
                        @php
                            $initial = mb_substr($tag->name, 0, 1);
                        @endphp
                        <tr>
                            <td>
                                <div class="lead-cell-contact">

                                    <div class="lead-name-box">
                                        <div class="d-inline-flex align-items-center gap-1">
                                            <strong class="text-dark"><i
                                                    class="bi bi-hash text-muted me-1"></i>{{ $tag->name }}</strong>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="font-monospace text-muted small bg-light px-2 py-1 rounded border">
                                    {{ $tag->slug }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-secondary text-white rounded-pill px-3 py-2">
                                    {{ $tag->blogs_count }} Articles
                                </span>
                            </td>
                            {{-- <td>
                                @if ($tag->is_active)
                                    <span class="status-badge status-won">
                                        <i class="bi bi-check-circle me-1"></i> Active
                                    </span>
                                @else
                                    <span class="status-badge status-lost">
                                        <i class="bi bi-x-circle me-1"></i> Inactive
                                    </span>
                                @endif
                            </td> --}}
                            <td class="text-end-align nowrap-cell">
                                <div class="table-actions">
                                    @can('edit-blog-tags')
                                        <a href="{{ route('admin.blog-tags.edit', $tag) }}"
                                            class="btn-action btn-action-edit btn-action-icon" title="Edit Tag">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                    @endcan
                                    @can('delete-blog-tags')
                                        <form action="{{ route('admin.blog-tags.destroy', $tag) }}" method="POST"
                                            class="d-inline" onsubmit="return confirm('Delete tag?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-action btn-action-delete btn-action-icon"
                                                title="Delete Tag">
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
                                    <i class="bi bi-tags text-secondary fs-1"></i>
                                    <h5 class="mt-2 text-dark">No Tags Found</h5>
                                    @can('create-blog-tags')
                                        <a href="{{ route('admin.blog-tags.create') }}" class="btn primary btn-sm mt-2">
                                            <i class="bi bi-plus-lg me-1"></i> Add Tag
                                        </a>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($tags->hasPages())
            <div class="p-3 border-top d-flex justify-content-end">
                {{ $tags->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
@endsection
