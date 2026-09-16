@extends('admin.layouts.admin-master')

@section('title', $page->title . ' - Page Details')

@section('content')
    <div class="heading">
        <div>
            <small>AGENCY ADMIN / CMS PAGES</small>
            <h1>{{ $page->title }}</h1>
            <p>View page details and content.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.pages.index') }}" class="btn light">
                <i class="bi bi-arrow-left me-1"></i> Back to Pages
            </a>
            @can('edit-pages')
                <a href="{{ route('admin.pages.edit', $page) }}" class="btn primary">
                    <i class="bi bi-pencil-square me-1"></i> Edit Page
                </a>
            @endcan
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Page Content</h5>
                    @if ($page->status->value === 'published')
                        <span class="status-badge status-won">
                            <i class="bi bi-check-circle-fill me-1"></i> Published
                        </span>
                    @else
                        <span class="status-badge status-lost">
                            <i class="bi bi-journal-x me-1"></i> Draft
                        </span>
                    @endif
                </div>
                <div class="card-body">
                    <h2 class="h4 text-dark mb-2">{{ $page->title }}</h2>

                    @if ($page->subtitle)
                        <h3 class="h6 text-muted fw-normal mb-4">{{ $page->subtitle }}</h3>
                    @endif

                    @if ($page->featured_image)
                        <div class="mb-4 rounded overflow-hidden">
                            <img src="{{ Str::startsWith($page->featured_image, ['http://', 'https://']) ? $page->featured_image : Storage::url($page->featured_image) }}"
                                alt="Featured Image" class="img-fluid w-100" style="max-height: 400px; object-fit: cover;">
                        </div>
                    @endif

                    <div class="content-preview border rounded p-4 bg-light mt-4">
                        @if ($page->content)
                            {!! nl2br(e($page->content)) !!}
                        @else
                            <div class="text-muted text-center fst-italic py-5">No content provided for this page.</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Page Metadata</h5>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                            <span class="text-muted fw-semibold">URL Slug</span>
                            <span class="text-dark">/{{ $page->slug }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                            <span class="text-muted fw-semibold">Template</span>
                            <span class="text-dark">{{ $page->template }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                            <span class="text-muted fw-semibold">Sort Order</span>
                            <span class="text-dark">{{ $page->sort_order }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                            <span class="text-muted fw-semibold">Created At</span>
                            <span class="text-dark">{{ $page->created_at->format('M d, Y h:i A') }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                            <span class="text-muted fw-semibold">Last Updated</span>
                            <span class="text-dark">{{ $page->updated_at->format('M d, Y h:i A') }}</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">SEO Metadata</h5>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item py-3">
                            <div class="text-muted fw-semibold mb-1">Meta Title</div>
                            <div class="text-dark">{{ $page->seo?->meta_title ?? '—' }}</div>
                        </li>
                        <li class="list-group-item py-3">
                            <div class="text-muted fw-semibold mb-1">Meta Description</div>
                            <div class="text-dark small">{{ $page->seo?->meta_description ?? '—' }}</div>
                        </li>
                        <li class="list-group-item py-3">
                            <div class="text-muted fw-semibold mb-1">Meta Keywords</div>
                            <div class="text-dark small">{{ $page->seo?->meta_keywords ?? '—' }}</div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
