@extends('admin.layouts.admin-master')

@section('title', 'Case Study: ' . $caseStudy->title)

@section('content')
    <div class="mb-3">
        <a href="{{ route('admin.case-studies.index') }}" class="btn light btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Back to Case Studies
        </a>
    </div>

    @if (session('success'))
        <div class="alert-custom alert-custom-success">
            <i class="bi bi-check-circle-fill"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="dossier-hero">
        <div class="dossier-hero-title align-items-start">
            <div class="me-3">
                @if ($caseStudy->featured_image)
                    <img src="{{ Str::startsWith($caseStudy->featured_image, ['http://', 'https://']) ? $caseStudy->featured_image : Storage::url($caseStudy->featured_image) }}"
                        alt="Cover" class="rounded border" style="width: 120px; height: 120px; object-fit: cover;">
                @else
                    <div class="bg-light rounded d-flex align-items-center justify-content-center border"
                        style="width: 120px; height: 120px;">
                        <i class="bi bi-image text-muted fs-1"></i>
                    </div>
                @endif
            </div>
            <div class="dossier-hero-info">
                <h2>{{ $caseStudy->title }}</h2>
                <p>
                    @if ($caseStudy->project)
                        <i class="bi bi-briefcase me-1"></i> <strong>Project:</strong> {{ $caseStudy->project->title }} &bull;
                    @endif
                    <span>Created {{ $caseStudy->created_at->format('M d, Y') }}</span>
                </p>
                <div class="mt-2">
                    @if ($caseStudy->status->value === 'published')
                        <span class="status-badge status-won fs-6 py-1 px-3">
                            <i class="bi bi-check-circle-fill me-1"></i> Published
                        </span>
                    @else
                        <span class="status-badge status-lost fs-6 py-1 px-3">
                            <i class="bi bi-journal-x me-1"></i> Draft
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <div class="dossier-hero-actions">
            @can('edit-case-studies')
                <a href="{{ route('admin.case-studies.edit', $caseStudy) }}" class="btn light">
                    <i class="bi bi-pencil-square me-1"></i> Edit
                </a>
            @endcan

            @can('delete-case-studies')
                <form action="{{ route('admin.case-studies.destroy', $caseStudy) }}" method="POST" class="d-inline"
                    onsubmit="return confirm('Are you sure you want to delete this case study?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn light text-danger" title="Delete Case Study">
                        <i class="bi bi-trash3"></i>
                    </button>
                </form>
            @endcan
        </div>
    </div>

    <div class="dossier-grid mt-4">
        <div>
            <div class="dossier-card">
                <h3 class="dossier-card-title">
                    <i class="bi bi-exclamation-triangle-fill text-warning"></i> Challenges & Solutions
                </h3>
                @if ($caseStudy->challenges->isNotEmpty())
                    <div class="accordion mt-3" id="challengesAccordion">
                        @foreach ($caseStudy->challenges as $index => $challenge)
                            <div class="accordion-item mb-2 border rounded">
                                <h2 class="accordion-header" id="heading-{{ $index }}">
                                    <button class="accordion-button {{ $index === 0 ? '' : 'collapsed' }} fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $index }}" aria-expanded="{{ $index === 0 ? 'true' : 'false' }}" aria-controls="collapse-{{ $index }}">
                                        Challenge {{ $index + 1 }}: {{ $challenge->title }}
                                    </button>
                                </h2>
                                <div id="collapse-{{ $index }}" class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}" aria-labelledby="heading-{{ $index }}" data-bs-parent="#challengesAccordion">
                                    <div class="accordion-body">
                                        @if($challenge->description)
                                            <p class="mb-3 text-muted">{{ $challenge->description }}</p>
                                        @endif
                                        
                                        <h6 class="fw-bold mb-2"><i class="bi bi-wrench text-primary"></i> Solution Attempts:</h6>
                                        @if($challenge->solutions->isNotEmpty())
                                            <ul class="list-group list-group-flush">
                                                @foreach($challenge->solutions as $solution)
                                                    <li class="list-group-item d-flex justify-content-between align-items-center px-0 bg-transparent">
                                                        <span>{{ $solution->description }}</span>
                                                        @if($solution->status)
                                                            <span class="badge {{ $solution->status->badgeClass() }}">
                                                                {{ $solution->status->label() }}
                                                            </span>
                                                        @endif
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <p class="text-muted small fst-italic mb-0">No solution attempts recorded.</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted fst-italic">No challenges documented.</p>
                @endif
            </div>

            <div class="dossier-card">
                <h3 class="dossier-card-title">
                    <i class="bi bi-trophy-fill text-primary"></i> The Results
                </h3>
                @if ($caseStudy->result)
                    <div class="dossier-message-box">
                        {!! nl2br(e($caseStudy->result)) !!}
                    </div>
                @else
                    <p class="text-muted fst-italic">No results documented.</p>
                @endif
            </div>

            <div class="dossier-card">
                <h3 class="dossier-card-title">
                    <i class="bi bi-file-text-fill text-secondary"></i> Full Content
                </h3>
                @if ($caseStudy->content)
                    <div class="p-3 bg-light rounded border">
                        {!! $caseStudy->content !!}
                    </div>
                @else
                    <p class="text-muted fst-italic">No additional content provided.</p>
                @endif
            </div>
        </div>

        <div>
            <div class="dossier-card">
                <h3 class="dossier-card-title">
                    <i class="bi bi-info-circle-fill text-info"></i> Meta Information
                </h3>
                <div class="dossier-data-row">
                    <span class="dossier-label">Slug</span>
                    <span class="dossier-value">{{ $caseStudy->slug }}</span>
                </div>
                <div class="dossier-data-row">
                    <span class="dossier-label">Status</span>
                    <span class="dossier-value">{{ ucfirst($caseStudy->status->value) }}</span>
                </div>
                <div class="dossier-data-row">
                    <span class="dossier-label">Published At</span>
                    <span class="dossier-value">{{ $caseStudy->published_at ? $caseStudy->published_at->format('M d, Y h:i A') : '—' }}</span>
                </div>
                <div class="dossier-data-row">
                    <span class="dossier-label">Created At</span>
                    <span class="dossier-value">{{ $caseStudy->created_at->format('M d, Y h:i A') }}</span>
                </div>
            </div>

            <div class="dossier-card border-primary">
                <h3 class="dossier-card-title text-primary">
                    <i class="bi bi-graph-up-arrow"></i> Key Metrics
                </h3>
                @if ($caseStudy->metrics->isNotEmpty())
                    <ul class="list-group list-group-flush mt-2">
                        @foreach ($caseStudy->metrics as $metric)
                            <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent px-0 border-light">
                                <span class="fw-semibold text-dark">{{ $metric->metric_name }}</span>
                                <span class="fs-5 text-primary fw-bold">
                                    {{ $metric->metric_value }}{{ $metric->metric_suffix }}
                                </span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-muted fst-italic mt-2 mb-0">No key metrics defined.</p>
                @endif
            </div>
        </div>
    </div>
@endsection
