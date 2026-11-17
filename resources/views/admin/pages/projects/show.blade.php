@extends('admin.layouts.admin-master')

@section('title', 'Project Dossier — ' . $project->title)

@section('content')
    {{-- Back Link & Section Info --}}
    <div class="mb-3">
        <a href="{{ route('admin.projects.index') }}" class="btn light btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Back to Projects
        </a>
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

    @php
        $initials = collect(explode(' ', $project->title))
            ->map(fn($w) => mb_substr($w, 0, 1))
            ->take(2)
            ->join('');
    @endphp

    {{-- Hero Dossier Header --}}
    <div class="dossier-hero">
        <div class="dossier-hero-title">
            <div class="dossier-avatar-large"
                @if ($project->featured_image) style="background-image: url('{{ Storage::url($project->featured_image) }}'); background-size: cover; background-position: center; color: transparent;" @endif>
                {{ strtoupper($initials ?: 'P') }}
            </div>
            <div class="dossier-hero-info">
                <h2>
                    {{ $project->title }}
                    @if ($project->is_featured)
                        <x-verified-badge title="Featured Project" />
                    @endif
                </h2>
                <p>
                    @if ($project->client)
                        <i class="bi bi-building me-1"></i>
                        <strong>{{ $project->client->company_name ?? $project->client->contact_person }}</strong> &bull;
                    @endif
                    <span>Started {{ $project->start_date ? $project->start_date->format('M d, Y') : 'Unspecified' }}</span>
                    @if ($project->industry)
                        &bull; <span class="badge bg-light text-dark border">{{ $project->industry->name }}</span>
                    @endif
                </p>
            </div>
        </div>

        <div class="dossier-hero-actions">
            {{-- Status Badge --}}
            <span class="status-badge {{ $project->status->badgeClass() }} fs-6 py-2 px-3">
                <i class="bi {{ $project->status->icon() }} me-1"></i> {{ $project->status->label() }}
            </span>

            {{-- Smart Action Buttons based on lifecycle stage --}}
            @can('edit-projects')
                @if ($project->status === \App\Enums\ProjectStatus::Upcoming)
                    <form action="{{ route('admin.projects.update-status', $project) }}" method="POST" class="d-inline"
                        onsubmit="return confirm('Are you sure you want to change this project\'s status?');">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="ongoing">
                        <button type="submit" class="btn primary">
                            <i class="bi bi-play-circle me-1"></i> Start Project
                        </button>
                    </form>
                @elseif ($project->status === \App\Enums\ProjectStatus::Ongoing)
                    <form action="{{ route('admin.projects.update-status', $project) }}" method="POST" class="d-inline"
                        onsubmit="return confirm('Are you sure you want to change this project\'s status?');">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="completed">
                        <button type="submit" class="btn primary">
                            <i class="bi bi-check2-circle me-1"></i> Mark Completed
                        </button>
                    </form>
                @elseif ($project->status === \App\Enums\ProjectStatus::OnHold)
                    <form action="{{ route('admin.projects.update-status', $project) }}" method="POST" class="d-inline"
                        onsubmit="return confirm('Are you sure you want to change this project\'s status?');">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="ongoing">
                        <button type="submit" class="btn primary">
                            <i class="bi bi-play-circle me-1"></i> Resume Project
                        </button>
                    </form>
                @endif
            @endcan

            {{-- Edit Button --}}
            @can('edit-projects')
                <a href="{{ route('admin.projects.edit', $project) }}" class="btn light">
                    <i class="bi bi-pencil-square me-1"></i> Edit
                </a>
            @endcan

            {{-- Delete Button --}}
            @can('delete-projects')
                <form action="{{ route('admin.projects.destroy', $project) }}" method="POST" class="d-inline"
                    onsubmit="return confirm('Are you sure you want to delete this project?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn light text-danger" title="Delete Project">
                        <i class="bi bi-trash3"></i>
                    </button>
                </form>
            @endcan
        </div>
    </div>

    {{-- Visual Pipeline Stepper --}}
    @php
        $pipelineStages = [
            \App\Enums\ProjectStatus::Upcoming,
            \App\Enums\ProjectStatus::Ongoing,
            \App\Enums\ProjectStatus::Completed,
        ];
        $isHold = $project->status === \App\Enums\ProjectStatus::OnHold;
        $currentStageIndex = array_search($project->status, $pipelineStages);
        if ($currentStageIndex === false) {
            $currentStageIndex = -1;
        }

    @endphp



    {{-- Dossier Content Grid --}}
    <div class="dossier-grid">
        {{-- Left Column: Project Details & Requirements --}}
        <div>
            {{-- Project Description --}}
            <div class="dossier-card">
                <h3 class="dossier-card-title">
                    <i class="bi bi-card-text text-primary"></i> Project Details
                </h3>
                @if ($project->short_description)
                    <div class="mb-3 pb-3 border-bottom">
                        <strong>Brief:</strong> {{ $project->short_description }}
                    </div>
                @endif
                @if ($project->description)
                    <div class="dossier-message-box mt-3" style="white-space: pre-line;">
                        {{ $project->description }}
                    </div>
                @else
                    <p class="text-muted fst-italic">No full description provided.</p>
                @endif
            </div>

            {{-- Attached Services --}}
            <div class="dossier-card">
                <h3 class="dossier-card-title">
                    <i class="bi bi-layers-fill text-primary"></i> Delivered Services
                </h3>
                @if ($project->services->isNotEmpty())
                    <div class="d-flex flex-wrap gap-2">
                        @foreach ($project->services as $service)
                            <div class="p-2 px-3 border rounded bg-light d-flex align-items-center gap-2">
                                <i class="bi {{ $service->icon ?: 'bi-check-circle' }} text-primary"></i>
                                <span class="fw-semibold text-dark">{{ $service->name }}</span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted fst-italic">No specific services attached to this project.</p>
                @endif
            </div>
        </div>

        {{-- Right Column: Deal Overview & Key Parameters --}}
        <div>
            {{-- Project Timeline & Data --}}
            <div class="dossier-card">
                <h3 class="dossier-card-title">
                    <i class="bi bi-calendar3 text-primary"></i> Timeline & Links
                </h3>

                <div class="dossier-data-row">
                    <span class="dossier-label">Start Date</span>
                    <span class="dossier-value fw-semibold text-dark">
                        {{ $project->start_date ? $project->start_date->format('M d, Y') : '—' }}
                    </span>
                </div>
                <div class="dossier-data-row">
                    <span class="dossier-label">Completion Date</span>
                    <span class="dossier-value fw-semibold text-success">
                        {{ $project->completion_date ? $project->completion_date->format('M d, Y') : '—' }}
                    </span>
                </div>

                <div class="dossier-data-row">
                    <span class="dossier-label">Live Project Link</span>
                    <span class="dossier-value">
                        @if ($project->project_url)
                            <a href="{{ Str::startsWith($project->project_url, 'http') ? $project->project_url : 'https://' . $project->project_url }}"
                                target="_blank" rel="noopener noreferrer" class="text-decoration-none">
                                View Live Site <i class="bi bi-box-arrow-up-right small ms-1"></i>
                            </a>
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </span>
                </div>

                <div class="dossier-data-row">
                    <span class="dossier-label">Created At</span>
                    <span class="dossier-value text-muted small">{{ $project->created_at->format('M d, Y h:i A') }}</span>
                </div>
            </div>

            {{-- Client Data --}}
            @if ($project->client)
                <div class="dossier-card border-primary">
                    <h3 class="dossier-card-title text-primary">
                        <i class="bi bi-building"></i> Client Information
                    </h3>
                    <div class="dossier-data-row">
                        <span class="dossier-label">Company Name</span>
                        <span class="dossier-value fw-bold">{{ $project->client->company_name }}</span>
                    </div>
                    <div class="dossier-data-row">
                        <span class="dossier-label">Contact Person</span>
                        <span class="dossier-value">{{ $project->client->contact_person }}</span>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('admin.clients') }}" class="btn light btn-sm w-100">
                            <i class="bi bi-arrow-right me-1"></i> View Client Details
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
