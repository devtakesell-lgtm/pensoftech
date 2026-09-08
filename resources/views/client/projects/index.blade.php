@extends('client.layouts.client-master')

@section('title', 'My Projects')
@section('page_title', 'My Projects')
@section('breadcrumb_current', 'Projects')

@section('content')
    <!-- Filter Tabs & Actions -->
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px; margin-bottom: 24px;">
        <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
            <a href="{{ route('client.projects.index') }}" 
               class="btn-secondary" 
               style="{{ !request('status') ? 'background-color: var(--cp-primary-light); color: var(--cp-primary); border-color: var(--cp-primary-border);' : '' }}">
                <span>All Projects</span>
            </a>
            @foreach ($statusOptions as $statusCase)
                <a href="{{ route('client.projects.index', ['status' => $statusCase->value]) }}" 
                   class="btn-secondary" 
                   style="{{ request('status') === $statusCase->value ? 'background-color: var(--cp-primary-light); color: var(--cp-primary); border-color: var(--cp-primary-border);' : '' }}">
                    <span>{{ $statusCase->label() }}</span>
                </a>
            @endforeach
        </div>

        <a href="{{ route('client.leads.create') }}" class="btn-primary">
            <i class="bi bi-plus-lg"></i>
            <span>Request New Project</span>
        </a>
    </div>

    <!-- Projects Grid -->
    @if ($projects->isEmpty())
        <div class="portal-card">
            <div class="empty-state">
                <div class="empty-state-icon">
                    <i class="bi bi-folder-x"></i>
                </div>
                <h3 class="empty-state-title">No Projects Found</h3>
                <p class="empty-state-text">
                    @if (request('status'))
                        No projects matched your selected status filter. Try viewing all projects.
                    @else
                        You don't have any active or previous projects assigned to your account yet.
                    @endif
                </p>
                <div style="display: flex; justify-content: center; gap: 12px;">
                    @if (request('status'))
                        <a href="{{ route('client.projects.index') }}" class="btn-secondary">Clear Filter</a>
                    @endif
                    <a href="{{ route('client.leads.create') }}" class="btn-primary">Start a New Project</a>
                </div>
            </div>
        </div>
    @else
        <div class="projects-grid">
            @foreach ($projects as $project)
                <div class="project-card">
                    <div class="project-card-image-wrap">
                        @if ($project->featured_image)
                            <img src="{{ asset('storage/' . $project->featured_image) }}" alt="{{ $project->title }}" class="project-card-image">
                        @else
                            <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #1e293b, #334155); color: #ffffff; font-size: 2.5rem;">
                                <i class="bi bi-laptop"></i>
                            </div>
                        @endif
                        <div class="project-card-status-badge">
                            <span class="status-badge status-badge-{{ $project->status->value }}">
                                {{ $project->status->label() }}
                            </span>
                        </div>
                    </div>

                    <div class="project-card-body">
                        <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px;">
                            @if ($project->industry)
                                <span style="font-size: 0.75rem; font-weight: 600; color: var(--cp-primary); background-color: var(--cp-primary-light); padding: 2px 8px; border-radius: var(--cp-radius-sm);">
                                    {{ $project->industry->name }}
                                </span>
                            @endif
                        </div>

                        <h3 class="project-card-title">
                            <a href="{{ route('client.projects.show', $project) }}">
                                {{ $project->title }}
                            </a>
                        </h3>

                        <p class="project-card-desc">
                            {{ $project->short_description ?? 'Digital development and engineering solution provided by PenSoftTech.' }}
                        </p>

                        @if ($project->services->isNotEmpty())
                            <div class="project-services-list">
                                @foreach ($project->services->take(3) as $service)
                                    <span class="service-chip">{{ $service->name }}</span>
                                @endforeach
                                @if ($project->services->count() > 3)
                                    <span class="service-chip">+{{ $project->services->count() - 3 }}</span>
                                @endif
                            </div>
                        @endif

                        <div class="project-card-footer">
                            <div>
                                <i class="bi bi-calendar3" style="margin-right: 4px;"></i>
                                <span>{{ $project->start_date ? $project->start_date->format('M d, Y') : 'Ongoing' }}</span>
                            </div>
                            <a href="{{ route('client.projects.show', $project) }}" class="portal-card-action-link">
                                <span>Details</span>
                                <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div style="margin-top: 32px;">
            {{ $projects->links() }}
        </div>
    @endif
@endsection
