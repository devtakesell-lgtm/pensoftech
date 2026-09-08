@extends('client.layouts.client-master')

@section('title', $project->title . ' — Project Details')
@section('page_title', $project->title)
@section('breadcrumb_current', 'Project Details')

@section('content')
    <!-- Back to Projects & Actions -->
    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px; flex-wrap: wrap; gap: 12px;">
        <a href="{{ route('client.projects.index') }}" class="btn-secondary">
            <i class="bi bi-arrow-left"></i>
            <span>Back to Projects</span>
        </a>

        <div style="display: flex; align-items: center; gap: 12px;">
            <span class="status-badge status-badge-{{ $project->status->value }}" style="font-size: 0.85rem; padding: 6px 14px;">
                {{ $project->status->label() }}
            </span>
            @if ($project->project_url)
                <a href="{{ $project->project_url }}" target="_blank" rel="noopener noreferrer" class="btn-secondary">
                    <i class="bi bi-box-arrow-up-right"></i>
                    <span>Live Preview</span>
                </a>
            @endif
        </div>
    </div>

    <!-- Main Project Layout -->
    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px;">
        <!-- Left: Project Narrative & Services -->
        <div>
            <div class="portal-card">
                @if ($project->featured_image)
                    <div style="height: 320px; overflow: hidden; background-color: #f1f5f9; border-bottom: 1px solid var(--cp-border);">
                        <img src="{{ asset('storage/' . $project->featured_image) }}" alt="{{ $project->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                @endif
                <div class="portal-card-body">
                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 12px;">
                        @if ($project->industry)
                            <span style="font-size: 0.8rem; font-weight: 600; color: var(--cp-primary); background-color: var(--cp-primary-light); padding: 3px 10px; border-radius: var(--cp-radius-sm);">
                                {{ $project->industry->name }}
                            </span>
                        @endif
                        @if ($project->is_featured)
                            <span style="font-size: 0.8rem; font-weight: 600; color: #b45309; background-color: #fffbeb; padding: 3px 10px; border-radius: var(--cp-radius-sm);">
                                <i class="bi bi-star-fill" style="color: #f59e0b; margin-right: 3px;"></i> Featured Project
                            </span>
                        @endif
                    </div>

                    <h2 style="font-size: 1.5rem; font-weight: 800; color: var(--cp-dark); margin-bottom: 16px;">
                        {{ $project->title }}
                    </h2>

                    @if ($project->short_description)
                        <div style="font-size: 1rem; color: var(--cp-ink); font-weight: 500; line-height: 1.6; margin-bottom: 24px; padding-bottom: 16px; border-bottom: 1px solid var(--cp-border-light);">
                            {{ $project->short_description }}
                        </div>
                    @endif

                    <div style="font-size: 0.94rem; color: var(--cp-ink); line-height: 1.7;">
                        @if ($project->description)
                            {!! nl2br(e($project->description)) !!}
                        @else
                            <p style="color: var(--cp-ink-muted);">Detailed project specifications and deliverables are actively maintained by your project manager.</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Associated Case Studies -->
            @if ($project->caseStudies->isNotEmpty())
                <div class="portal-card">
                    <div class="portal-card-header">
                        <h3 class="portal-card-title">
                            <i class="bi bi-journal-text text-primary"></i>
                            <span>Project Case Studies & Milestones</span>
                        </h3>
                    </div>
                    <div class="portal-card-body">
                        <div style="display: flex; flex-direction: column; gap: 16px;">
                            @foreach ($project->caseStudies as $caseStudy)
                                <div style="padding: 16px; border: 1px solid var(--cp-border); border-radius: var(--cp-radius-md);">
                                    <h4 style="font-size: 1.05rem; font-weight: 700; color: var(--cp-dark); margin-bottom: 6px;">
                                        {{ $caseStudy->title }}
                                    </h4>
                                    <p style="font-size: 0.85rem; color: var(--cp-ink-muted); line-height: 1.5;">
                                        {{ $caseStudy->summary ?? Str::limit(strip_tags($caseStudy->challenge), 160) }}
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Right: Project Metadata & Support -->
        <div>
            <!-- Metadata Card -->
            <div class="portal-card">
                <div class="portal-card-header">
                    <h3 class="portal-card-title">
                        <i class="bi bi-info-circle text-primary"></i>
                        <span>Project Overview</span>
                    </h3>
                </div>
                <div class="portal-card-body" style="display: flex; flex-direction: column; gap: 18px;">
                    <div>
                        <div style="font-size: 0.74rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: var(--cp-ink-subtle);">
                            Client Account
                        </div>
                        <div style="font-size: 0.92rem; font-weight: 600; color: var(--cp-dark); margin-top: 3px;">
                            {{ $client->company_name ?? $client->contact_person }}
                        </div>
                    </div>

                    <div>
                        <div style="font-size: 0.74rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: var(--cp-ink-subtle);">
                            Current Status
                        </div>
                        <div style="margin-top: 5px;">
                            <span class="status-badge status-badge-{{ $project->status->value }}">
                                {{ $project->status->label() }}
                            </span>
                        </div>
                    </div>

                    <div>
                        <div style="font-size: 0.74rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: var(--cp-ink-subtle);">
                            Timeline Schedule
                        </div>
                        <div style="display: flex; flex-direction: column; gap: 6px; margin-top: 6px; font-size: 0.86rem;">
                            <div style="display: flex; justify-content: space-between;">
                                <span style="color: var(--cp-ink-muted);">Start Date:</span>
                                <span style="font-weight: 600; color: var(--cp-dark);">
                                    {{ $project->start_date ? $project->start_date->format('M d, Y') : 'Not specified' }}
                                </span>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <span style="color: var(--cp-ink-muted);">Target Delivery:</span>
                                <span style="font-weight: 600; color: var(--cp-dark);">
                                    {{ $project->completion_date ? $project->completion_date->format('M d, Y') : 'In progress' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    @if ($project->services->isNotEmpty())
                        <div>
                            <div style="font-size: 0.74rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: var(--cp-ink-subtle); margin-bottom: 8px;">
                                Integrated Services
                            </div>
                            <div style="display: flex; flex-wrap: wrap; gap: 6px;">
                                @foreach ($project->services as $service)
                                    <span class="service-chip">{{ $service->name }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Help & Discussion Card -->
            <div class="portal-card">
                <div class="portal-card-body">
                    <div style="font-size: 1rem; font-weight: 700; color: var(--cp-dark); margin-bottom: 8px; display: flex; align-items: center; gap: 8px;">
                        <i class="bi bi-question-diamond-fill" style="color: var(--cp-primary);"></i>
                        <span>Need Changes or Scope Additions?</span>
                    </div>
                    <p style="font-size: 0.82rem; color: var(--cp-ink-muted); line-height: 1.5; margin-bottom: 16px;">
                        Submit a new service request or schedule a progress check-in directly through the client portal.
                    </p>
                    <a href="{{ route('client.leads.create') }}" class="btn-primary" style="width: 100%; justify-content: center;">
                        <i class="bi bi-pencil-square"></i>
                        <span>Request Change / Expansion</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
