@extends('admin.layouts.admin-master')

@section('title', 'Blog Comments Management')

@section('content')
    <div class="heading">
        <div>
            <small>CONTENT ADMIN</small>
            <h1>Blog Comments</h1>
            <p>Manage, moderate, and reply to comments left on your blog posts.</p>
        </div>
    </div>

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

    {{-- Pipeline KPI Cards --}}
    <div class="lead-stats-grid">
        <div class="lead-stat-card">
            <div class="lead-stat-icon icon-primary">
                <i class="bi bi-chat-dots"></i>
            </div>
            <div class="lead-stat-content">
                <h4>{{ number_format($totalCount) }}</h4>
                <span>Total Comments</span>
            </div>
        </div>

        <div class="lead-stat-card">
            <div class="lead-stat-icon icon-success">
                <i class="bi bi-check-circle-fill"></i>
            </div>
            <div class="lead-stat-content">
                <h4>{{ number_format($approvedCount) }}</h4>
                <span>Approved</span>
            </div>
        </div>

        <div class="lead-stat-card">
            <div class="lead-stat-icon icon-warning">
                <i class="bi bi-clock"></i>
            </div>
            <div class="lead-stat-content">
                <h4>{{ number_format($pendingCount) }}</h4>
                <span>Pending</span>
            </div>
        </div>

        <div class="lead-stat-card">
            <div class="lead-stat-icon icon-danger">
                <i class="bi bi-slash-circle"></i>
            </div>
            <div class="lead-stat-content">
                <h4>{{ number_format($spamCount) }}</h4>
                <span>Spam</span>
            </div>
        </div>
    </div>

    <div class="card list-card">
        {{-- Search & Filters --}}
        <div class="toolbar">
            <form method="GET" action="{{ route('admin.blog-comments.index') }}" class="toolbar-filters flex-wrap">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search comments, names..."
                    class="filter-search-input">

                <select name="status" onchange="this.form.submit()" class="filter-select">
                    <option value="">All Statuses</option>
                    @foreach (\App\Enums\CommentStatus::cases() as $status)
                        <option value="{{ $status->value }}" {{ request('status') === $status->value ? 'selected' : '' }}>
                            {{ $status->label() }}
                        </option>
                    @endforeach
                </select>

                <button type="submit" class="btn light">Filter</button>

                @if (request('search') || request('status'))
                    <a href="{{ route('admin.blog-comments.index') }}" class="btn light filter-btn-reset">Clear Filters</a>
                @endif
            </form>
        </div>

        <div class="tablewrap">
            <table>
                <thead>
                    <tr>
                        <th class="col-lead-contact">COMMENT INFO</th>
                        <th>POST & CONTEXT</th>
                        <th>CONTENT</th>
                        <th>STATUS</th>
                        <th class="text-end-align">ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($comments as $comment)
                        @php
                            $initials = collect(explode(' ', $comment->name))
                                ->map(fn($w) => mb_substr($w, 0, 1))
                                ->take(2)
                                ->join('');
                        @endphp
                        <tr>
                            <td>
                                <div class="lead-cell-contact">
                                    <div class="lead-avatar-circle">
                                        @if ($comment->user_id && $comment->user?->avatar)
                                            <img src="{{ asset('storage/' . $comment->user->avatar) }}"
                                                alt="{{ $comment->name }}" class="w-100 h-100 rounded-circle"
                                                style="object-fit: cover;">
                                        @else
                                            {{ strtoupper($initials ?: 'C') }}
                                        @endif
                                    </div>
                                    <div class="lead-name-box">
                                        <div class="d-inline-flex align-items-center gap-1">
                                            <strong>{{ $comment->name }}</strong>
                                            @if ($comment->user_id)
                                                <x-verified-badge title="Registered User" />
                                            @else
                                                <span class="badge bg-secondary ms-1"
                                                    style="font-size: 0.65em;">Guest</span>
                                            @endif
                                        </div>
                                        <div class="lead-contact-meta mt-1">
                                            <a href="mailto:{{ $comment->email }}" class="lead-contact-item"
                                                title="{{ $comment->email }}">
                                                <i class="bi bi-envelope"></i>
                                                <span class="lead-contact-text">{{ $comment->email }}</span>
                                            </a>
                                            <div class="lead-contact-item"
                                                title="{{ $comment->created_at->format('M d, Y h:i A') }}">
                                                <i class="bi bi-clock"></i>
                                                <span
                                                    class="lead-contact-text">{{ $comment->created_at->format('M d, Y h:i A') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if ($comment->blog)
                                    <a href="{{ route('admin.blog.show', $comment->blog_id) }}"
                                        class="text-decoration-none fw-bold text-dark d-block mb-1"
                                        style="font-size: 0.9em;">
                                        {{ Str::limit($comment->blog->title, 40) }}
                                    </a>
                                @else
                                    <span class="text-muted d-block mb-1">Deleted Post</span>
                                @endif

                                @if ($comment->parent_id)
                                    <div class="mt-2 p-1 bg-light rounded small border d-inline-block">
                                        <i class="bi bi-arrow-return-right text-muted me-1"></i>
                                        <span class="text-muted">Replying to:</span>
                                        <strong>{{ $comment->parent->name ?? 'Unknown' }}</strong>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div class="comment-content"
                                    style="max-height: 60px; overflow-y: auto; font-size: 0.9em; white-space: pre-wrap; line-height: 1.4;">
                                    {{ $comment->content }}</div>
                            </td>
                            <td>
                                @can('edit-blogs')
                                    <form action="{{ route('admin.blog-comments.update-status', $comment) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" data-original="{{ $comment->status->value }}"
                                            onchange="if(confirm('Are you sure you want to change this comment\'s status?')) { this.form.submit(); } else { this.value = this.getAttribute('data-original'); }"
                                            class="lead-status-select badge-{{ $comment->status->color() }}">
                                            @foreach (\App\Enums\CommentStatus::cases() as $statusOption)
                                                <option value="{{ $statusOption->value }}"
                                                    {{ $comment->status->value === $statusOption->value ? 'selected' : '' }}>
                                                    {{ $statusOption->label() }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </form>
                                @else
                                    <span class="status-badge badge-{{ $comment->status->color() }}">
                                        {{ $comment->status->label() }}
                                    </span>
                                @endcan
                            </td>
                            <td class="text-end-align nowrap-cell">
                                <div class="table-actions">
                                    @can('edit-blogs')
                                        <a href="#" data-bs-toggle="modal"
                                            data-bs-target="#replyModal{{ $comment->id }}"
                                            class="btn-action btn-action-view btn-action-icon" title="Reply">
                                            <i class="bi bi-reply-fill text-primary"></i>
                                        </a>
                                    @endcan

                                    @can('delete-blogs')
                                        <form action="{{ route('admin.blog-comments.destroy', $comment) }}" method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Are you sure you want to delete this comment? This will also delete all nested replies.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-action btn-action-delete btn-action-icon"
                                                title="Delete Comment">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                        </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>

                        {{-- Reply Modal --}}
                        <div class="modal fade" id="replyModal{{ $comment->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('admin.blog-comments.reply', $comment) }}" method="POST">
                                        @csrf
                                        <div class="modal-header">
                                            <h5 class="modal-title">Reply to {{ $comment->name }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3 p-3 bg-light rounded border">
                                                <div class="text-muted small mb-2"><i class="bi bi-quote"></i> Original
                                                    Comment</div>
                                                <div>{{ $comment->content }}</div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="content{{ $comment->id }}" class="form-label">Your
                                                    Reply</label>
                                                <textarea class="form-control" id="content{{ $comment->id }}" name="content" rows="4" required
                                                    placeholder="Write your reply here..."></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn primary"><i class="bi bi-send me-1"></i>
                                                Post Reply</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-5">
                                <div class="py-3">
                                    <i class="bi bi-chat-left-text text-secondary" style="font-size: 2.5rem;"></i>
                                    <h5 class="mt-2 text-dark">No Comments Found</h5>
                                    <p class="text-muted small">No blog comments match your filter parameters.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($comments->hasPages())
            <div class="pagination-container mt-3">
                {{ $comments->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
@endsection
