@extends('admin.layouts.admin-master')

@section('title', 'Article Dossier — ' . $blog->title)

@section('content')
    {{-- Back Link & Section Info --}}
    <div class="mb-3">
        <a href="{{ route('admin.blog.index') }}" class="btn light btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Back to Blog Posts
        </a>
    </div>

    {{-- Flash Alerts --}}
    @if (session('success'))
        <div class="alert-custom alert-custom-success">
            <i class="bi bi-check-circle-fill"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    {{-- Hero Card: Wide Thumbnail + Title --}}
    <div class="card mb-4">
        <div class="d-flex gap-4 align-items-center p-3">

            {{-- Featured Image (Wide Thumbnail) --}}
            @if ($blog->featured_image)
                <div class="blog-featured-thumb">
                    <img src="{{ Storage::url($blog->featured_image) }}"
                         alt="{{ $blog->title }}">
                </div>
            @else
                <div class="blog-featured-thumb-placeholder">
                    <div class="text-center">
                        <i class="bi bi-image fs-1"></i>
                        <div class="small mt-1">No Image</div>
                    </div>
                </div>
            @endif

            {{-- Post Info --}}
            <div class="flex-grow-1">
                <h2 class="mb-2 fw-bold fs-4">{{ $blog->title }}</h2>
                <p class="text-muted mb-3 small">
                    <i class="bi bi-person-circle me-1"></i>
                    <strong>{{ $blog->author?->name ?? 'System' }}</strong>
                    &bull;
                    <span>{{ $blog->created_at->format('M d, Y') }}</span>
                    @if ($blog->category)
                        &bull;
                        <span class="badge bg-light text-dark border">
                            <i class="bi bi-grid-fill text-primary"></i>
                            {{ $blog->category->name }}
                        </span>
                    @endif
                </p>

                {{-- Status Badge --}}
                <div class="mb-3">
                    @if ($blog->status === \App\Enums\ContentStatus::Published)
                        <span class="status-badge status-won">
                            <i class="bi bi-check-circle me-1"></i> {{ $blog->status->label() }}
                        </span>
                    @elseif($blog->status === \App\Enums\ContentStatus::Draft)
                        <span class="status-badge status-new">
                            <i class="bi bi-pencil me-1"></i> {{ $blog->status->label() }}
                        </span>
                    @else
                        <span class="status-badge status-qualified">
                            <i class="bi bi-eye-slash me-1"></i> {{ $blog->status->label() }}
                        </span>
                    @endif
                </div>

                {{-- Actions --}}
                <div class="d-flex gap-2 flex-wrap">
                    @if ($blog->status === \App\Enums\ContentStatus::Draft)
                        @can('edit-blogs')
                            <form action="{{ route('admin.blog.update', $blog) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Publish this article?');">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="title" value="{{ $blog->title }}">
                                <input type="hidden" name="status" value="{{ \App\Enums\ContentStatus::Published->value }}">
                                <button type="submit" class="btn primary">
                                    <i class="bi bi-rocket-takeoff me-1"></i> Publish
                                </button>
                            </form>
                        @endcan
                    @endif

                    @can('edit-blogs')
                        <a href="{{ route('admin.blog.edit', $blog) }}" class="btn light">
                            <i class="bi bi-pencil-square me-1"></i> Edit
                        </a>
                    @endcan

                    @can('delete-blogs')
                        <form action="{{ route('admin.blog.destroy', $blog) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Delete this blog post permanently?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn light text-danger">
                                <i class="bi bi-trash3 me-1"></i> Delete
                            </button>
                        </form>
                    @endcan
                </div>
            </div>
        </div>
    </div>


    {{-- Dossier Content Grid --}}
    <div class="dossier-grid">
        {{-- Left Column: Content Preview --}}
        <div>
            <div class="dossier-card">
                <h3 class="dossier-card-title">
                    <i class="bi bi-text-paragraph text-primary"></i> Article Content
                </h3>
                @if ($blog->excerpt)
                    <div class="p-3 mb-4 rounded bg-light border-start border-primary border-4">
                        <strong class="d-block mb-1 text-muted small">EXCERPT</strong>
                        <span class="fst-italic">{{ $blog->excerpt }}</span>
                    </div>
                @endif

                <div class="dossier-message-box overflow-y-auto max-h-800">
                    {!! $blog->content !!}
                </div>
            </div>
        </div>

        {{-- Right Column: Metadata & SEO --}}
        <div>
            {{-- Publish Details --}}
            <div class="dossier-card">
                <h3 class="dossier-card-title">
                    <i class="bi bi-calendar-event text-primary"></i> Publication Details
                </h3>
                <div class="dossier-data-row">
                    <span class="dossier-label">Status</span>
                    <span class="dossier-value fw-bold">{{ $blog->status->label() }}</span>
                </div>
                <div class="dossier-data-row">
                    <span class="dossier-label">Visibility</span>
                    <span class="dossier-value">
                        @if ($blog->is_featured)
                            <span class="badge bg-warning text-dark"><i class="bi bi-star-fill"></i> Featured</span>
                        @else
                            Standard
                        @endif
                    </span>
                </div>
                <div class="dossier-data-row">
                    <span class="dossier-label">Published On</span>
                    <span class="dossier-value">
                        {{ $blog->published_at ? $blog->published_at->format('M d, Y h:i A') : 'Not Published' }}
                    </span>
                </div>
                <div class="dossier-data-row">
                    <span class="dossier-label">Total Views</span>
                    <span class="dossier-value fs-5 text-primary"><i class="bi bi-eye"></i>
                        {{ number_format($blog->views) }}</span>
                </div>
            </div>

            {{-- Tags Integration --}}
            <div class="dossier-card">
                <h3 class="dossier-card-title">
                    <i class="bi bi-tags-fill text-primary"></i> Associated Tags
                </h3>
                @if ($blog->tags->isNotEmpty())
                    <div class="d-flex flex-wrap gap-2">
                        @foreach ($blog->tags as $tag)
                            <div class="p-1 px-3 border rounded bg-light d-flex align-items-center gap-2">
                                <i class="bi bi-hash text-muted"></i>
                                <span class="fw-semibold text-dark">{{ $tag->name }}</span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted fst-italic">No tags applied.</p>
                @endif
            </div>

            {{-- SEO Metadata --}}
            <div class="dossier-card">
                <h3 class="dossier-card-title">
                    <i class="bi bi-search text-primary"></i> Search Engine Optimization
                </h3>
                @if ($blog->seoMeta)
                    <div class="dossier-data-row flex-column align-items-start gap-1">
                        <span class="dossier-label mb-0">Meta Title</span>
                        <span class="dossier-value w-100 fw-bold">{{ $blog->seoMeta->meta_title ?? $blog->title }}</span>
                    </div>
                    <div class="dossier-data-row flex-column align-items-start gap-1">
                        <span class="dossier-label mb-0">Meta Description</span>
                        <span
                            class="dossier-value w-100 text-muted">{{ $blog->seoMeta->meta_description ?? 'Auto-generated from excerpt.' }}</span>
                    </div>

                    {{-- Google SERP Preview Simulation --}}
                    <div class="mt-4 p-3 border rounded bg-white">
                        <span class="d-block text-muted small mb-2 text-uppercase fw-bold"><i class="bi bi-google"></i> SERP Preview</span>
                        <div class="font-sans">
                            <div class="text-primary fs-5 lh-sm mb-1">
                                {{ Str::limit($blog->seoMeta->meta_title ?? $blog->title, 60) }}
                            </div>
                            <div class="text-success small lh-sm mb-1">
                                {{ url('/blog/' . $blog->slug) }}
                            </div>
                            <div class="text-secondary small lh-base">
                                {{ Str::limit($blog->seoMeta->meta_description ?? $blog->excerpt, 155) }}
                            </div>
                        </div>
                    </div>
                @else
                    <p class="text-muted fst-italic">No custom SEO metadata provided. System will use default title and
                        excerpt.</p>
                @endif
            </div>
        </div>
    </div>
@endsection
