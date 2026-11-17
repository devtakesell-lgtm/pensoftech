@extends('admin.layouts.admin-master')

@section('title', 'Blog Posts Management')

@section('content')
    {{-- Page Header --}}
    <div class="heading">
        <div>
            <small>CONTENT ADMIN</small>
            <h1>Blog & Articles</h1>
            <p>Manage your blog content, articles, publication status, and view metrics.</p>
        </div>
        <div>
            @can('create-blogs')
                <a href="{{ route('admin.blog.create') }}" class="btn primary">
                    <i class="bi bi-plus-lg me-1"></i> Write New Post
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

    {{-- Pipeline KPI Cards (Matching Leads Style) --}}
    <div class="lead-stats-grid">
        <div class="lead-stat-card">
            <div class="lead-stat-icon icon-primary">
                <i class="bi bi-journal-text"></i>
            </div>
            <div class="lead-stat-content">
                <h4>{{ number_format($totalCount) }}</h4>
                <span>Total Posts</span>
            </div>
        </div>

        <div class="lead-stat-card">
            <div class="lead-stat-icon icon-success">
                <i class="bi bi-check-circle-fill"></i>
            </div>
            <div class="lead-stat-content">
                <h4>{{ number_format($publishedCount) }}</h4>
                <span>Published</span>
            </div>
        </div>

        <div class="lead-stat-card">
            <div class="lead-stat-icon icon-warning">
                <i class="bi bi-pencil-square"></i>
            </div>
            <div class="lead-stat-content">
                <h4>{{ number_format($draftCount) }}</h4>
                <span>Drafts</span>
            </div>
        </div>

        <div class="lead-stat-card">
            <div class="lead-stat-icon icon-info">
                <i class="bi bi-eye-fill"></i>
            </div>
            <div class="lead-stat-content">
                <h4>{{ number_format($totalViews) }}</h4>
                <span>Total Views</span>
            </div>
        </div>
    </div>

    {{-- Blog Posts Table Card --}}
    <div class="card list-card">
        {{-- Search & Filters (Matching Leads Toolbar) --}}
        <div class="toolbar">
            <form method="GET" action="{{ route('admin.blog.index') }}" class="toolbar-filters flex-wrap">
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Search by title, excerpt..." class="filter-search-input">

                <select name="status" onchange="this.form.submit()" class="filter-select">
                    <option value="">All Statuses</option>
                    @foreach (\App\Enums\ContentStatus::cases() as $status)
                        <option value="{{ $status->value }}" {{ request('status') === $status->value ? 'selected' : '' }}>
                            {{ $status->label() }}
                        </option>
                    @endforeach
                </select>

                <select name="category_id" onchange="this.form.submit()" class="filter-select">
                    <option value="">All Categories</option>
                    @foreach ($categories ?? [] as $category)
                        <option value="{{ $category->id }}"
                            {{ (string) request('category_id') === (string) $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>

                <button type="submit" class="btn light">Filter</button>

                @if (request('search') || request('status') || request('category_id'))
                    <a href="{{ route('admin.blog.index') }}" class="btn light filter-btn-reset">
                        Reset
                    </a>
                @endif
            </form>
        </div>

        <div class="tablewrap">
            <table>
                <thead>
                    <tr>
                        <th class="col-lead-contact">ARTICLE</th>
                        <th>CATEGORY</th>
                        <th>AUTHOR</th>
                        <th>STATUS</th>
                        <th>Views</th>
                        <th class="text-end-align">ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($blogs as $post)
                        <tr>
                            <td>
                                <div class="lead-cell-contact">
                                    @if ($post->featured_image)
                                        <div class="lead-avatar-circle p-0 overflow-hidden rounded-3">
                                            <img src="{{ Storage::url($post->featured_image) }}" alt="Img" class="w-100 h-100 object-fit-cover">
                                        </div>
                                    @else
                                        <div class="lead-avatar-circle rounded-3">
                                            <i class="bi bi-image text-muted"></i>
                                        </div>
                                    @endif
                                    <div class="lead-name-box">
                                        <div class="d-inline-flex align-items-center gap-1">
                                            <a href="{{ route('admin.blog.show', $post) }}" class="text-decoration-none">
                                                <strong>{{ Str::limit($post->title, 50) }}</strong>
                                            </a>
                                        </div>
                                        <div class="lead-contact-meta mt-1">
                                            <span class="lead-contact-item text-muted">
                                                <i class="bi bi-calendar"></i>
                                                <span class="lead-contact-text">
                                                    {{ $post->published_at ? $post->published_at->format('M d, Y') : 'Unpublished' }}
                                                </span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if ($post->category)
                                    <span class="lead-source-pill">
                                        <i class="bi bi-grid-fill"></i> {{ $post->category->name }}
                                    </span>
                                @else
                                    <span class="text-muted small">—</span>
                                @endif
                            </td>
                            <td>
                                <span class="d-inline-flex align-items-center gap-1 text-secondary fw-semibold small">
                                    <i class="bi bi-person text-primary"></i> {{ $post->author?->name ?? 'System' }}
                                </span>
                            </td>
                            <td>
                                @if ($post->status === \App\Enums\ContentStatus::Published)
                                    <span class="status-badge status-won">
                                        <i class="bi bi-check-circle me-1"></i>
                                        {{ $post->status->label() }}
                                    </span>
                                @elseif($post->status === \App\Enums\ContentStatus::Draft)
                                    <span class="status-badge status-new">
                                        <i class="bi bi-pencil me-1"></i>
                                        {{ $post->status->label() }}
                                    </span>
                                @else
                                    <span class="status-badge status-qualified">
                                        <i class="bi bi-eye-slash me-1"></i>
                                        {{ $post->status->label() }}
                                    </span>
                                @endif
                            </td>
                            <td>
                                <span class="lead-budget-text fs-6">
                                    <i class="bi bi-eye"></i> {{ number_format($post->views) }}
                                </span>
                            </td>
                            <td class="text-end-align nowrap-cell">
                                <div class="table-actions">
                                    @can('view-blogs')
                                        <a href="{{ route('admin.blog.show', $post) }}"
                                            class="btn-action btn-action-view btn-action-icon" title="View Dossier">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    @endcan
                                    @can('edit-blogs')
                                        <a href="{{ route('admin.blog.edit', $post) }}"
                                            class="btn-action btn-action-edit btn-action-icon" title="Edit Post">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                    @endcan

                                    @can('delete-blogs')
                                        <form action="{{ route('admin.blog.destroy', $post) }}" method="POST" class="d-inline"
                                            onsubmit="return confirm('Are you sure you want to delete this post?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-action btn-action-delete btn-action-icon"
                                                title="Delete Post">
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
                                    <i class="bi bi-journal-text text-secondary fs-1"></i>
                                    <h5 class="mt-2 text-dark">No Posts Found</h5>
                                    <p class="text-muted small">No articles match your filter parameters.</p>
                                    @can('create-blogs')
                                        <a href="{{ route('admin.blog.create') }}" class="btn primary btn-sm mt-2">
                                            <i class="bi bi-plus-lg me-1"></i> Write New Post
                                        </a>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($blogs->hasPages())
            <div class="p-3 border-top d-flex justify-content-end">
                {{ $blogs->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
@endsection
