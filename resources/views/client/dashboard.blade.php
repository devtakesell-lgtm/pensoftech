@extends('client.layouts.client-master')

@section('title', 'Client Dashboard')
@section('page_title', 'Dashboard Overview')
@section('breadcrumb_current', 'Dashboard')

@section('content')
    <!-- Welcome Header Banner -->
    <div class="client-welcome-banner">
        <div class="client-welcome-content">
            <div class="client-welcome-badge">
                <i class="bi bi-shield-check"></i>
                <span>Client Workspace</span>
            </div>
            <h2 class="client-welcome-title">Welcome back, {{ explode(' ', auth()->user()->name)[0] }}!</h2>
            <p class="client-welcome-subtitle">
                Track your active digital deliverables, review project milestones, and submit service inquiries seamlessly.
            </p>
        </div>
        <div class="client-welcome-actions">
            <a href="{{ route('client.leads.create') }}" class="client-banner-btn">
                <i class="bi bi-plus-lg"></i>
                <span>Request Service</span>
            </a>
            <a href="{{ route('client.projects.index') }}" class="client-banner-btn-secondary">
                <i class="bi bi-folder2-open"></i>
                <span>View Projects</span>
            </a>
        </div>
    </div>

    <!-- KPI Statistics Grid -->
    <div class="client-stats-grid">
        <div class="stat-card">
            <div class="stat-card-top">
                <div class="stat-icon stat-icon-blue">
                    <i class="bi bi-briefcase"></i>
                </div>
                <span class="stat-pill stat-pill-blue">All Time</span>
            </div>
            <div class="stat-value">{{ $stats['total_projects'] }}</div>
            <div class="stat-label">Total Projects Assigned</div>
        </div>

        <div class="stat-card">
            <div class="stat-card-top">
                <div class="stat-icon stat-icon-amber">
                    <i class="bi bi-arrow-repeat"></i>
                </div>
                <span class="stat-pill stat-pill-amber">Active</span>
            </div>
            <div class="stat-value">{{ $stats['ongoing_projects'] }}</div>
            <div class="stat-label">Ongoing Deliverables</div>
        </div>

        <div class="stat-card">
            <div class="stat-card-top">
                <div class="stat-icon stat-icon-green">
                    <i class="bi bi-check2-circle"></i>
                </div>
                <span class="stat-pill stat-pill-green">Completed</span>
            </div>
            <div class="stat-value">{{ $stats['completed_projects'] }}</div>
            <div class="stat-label">Delivered Projects</div>
        </div>

        <div class="stat-card">
            <div class="stat-card-top">
                <div class="stat-icon stat-icon-purple">
                    <i class="bi bi-chat-square-text"></i>
                </div>
                <span class="stat-pill stat-pill-purple">Inquiries</span>
            </div>
            <div class="stat-value">{{ $stats['total_inquiries'] }}</div>
            <div class="stat-label">Requests & Inquiries</div>
        </div>
    </div>

    <!-- Two-Column Section: Projects & Inquiries -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(360px, 1fr)); gap: 24px;">
        <!-- Left: Recent Projects -->
        <div class="portal-card" style="margin-bottom: 0;">
            <div class="portal-card-header">
                <div>
                    <h2 class="portal-card-title">
                        <i class="bi bi-folder-check text-primary"></i>
                        <span>Recent Projects</span>
                    </h2>
                    <p class="portal-card-subtitle">Your latest project developments & milestones</p>
                </div>
                <a href="{{ route('client.projects.index') }}" class="portal-card-action-link">
                    <span>View all</span>
                    <i class="bi bi-arrow-right"></i>
                </a>
            </div>
            <div class="portal-card-body">
                @if ($recentProjects->isEmpty())
                    <div class="empty-state">
                        <div class="empty-state-icon">
                            <i class="bi bi-folder2"></i>
                        </div>
                        <h3 class="empty-state-title">No Projects Found</h3>
                        <p class="empty-state-text">You do not have any active or completed projects assigned to your account yet.</p>
                        <a href="{{ route('client.leads.create') }}" class="btn-primary">
                            <i class="bi bi-plus-lg"></i>
                            <span>Start a Project</span>
                        </a>
                    </div>
                @else
                    <div style="display: flex; flex-direction: column; gap: 16px;">
                        @foreach ($recentProjects as $project)
                            <div style="display: flex; align-items: center; justify-content: space-between; padding: 14px; border: 1px solid var(--cp-border); border-radius: var(--cp-radius-md); transition: var(--cp-transition);">
                                <div style="display: flex; align-items: center; gap: 14px;">
                                    <div style="width: 42px; height: 42px; border-radius: var(--cp-radius-md); background-color: var(--cp-primary-light); color: var(--cp-primary); display: flex; align-items: center; justify-content: center; font-size: 1.2rem;">
                                        <i class="bi bi-code-slash"></i>
                                    </div>
                                    <div>
                                        <a href="{{ route('client.projects.show', $project) }}" style="font-size: 0.95rem; font-weight: 700; color: var(--cp-dark);">
                                            {{ $project->title }}
                                        </a>
                                        <div style="display: flex; align-items: center; gap: 8px; margin-top: 4px; font-size: 0.78rem; color: var(--cp-ink-muted);">
                                            @if ($project->industry)
                                                <span>{{ $project->industry->name }}</span>
                                                <span>•</span>
                                            @endif
                                            <span>Started {{ $project->start_date ? $project->start_date->format('M Y') : 'Recently' }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div style="text-align: right;">
                                    <span class="status-badge status-badge-{{ $project->status->value }}">
                                        {{ $project->status->label() }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <!-- Right: Recent Inquiries & Requests -->
        <div class="portal-card" style="margin-bottom: 0;">
            <div class="portal-card-header">
                <div>
                    <h2 class="portal-card-title">
                        <i class="bi bi-chat-left-dots text-primary"></i>
                        <span>Recent Inquiries</span>
                    </h2>
                    <p class="portal-card-subtitle">Status of your submitted proposals & requests</p>
                </div>
                <a href="{{ route('client.leads.index') }}" class="portal-card-action-link">
                    <span>View all</span>
                    <i class="bi bi-arrow-right"></i>
                </a>
            </div>
            <div class="portal-card-body" style="padding: 0;">
                @if ($recentLeads->isEmpty())
                    <div class="empty-state">
                        <div class="empty-state-icon">
                            <i class="bi bi-envelope-open"></i>
                        </div>
                        <h3 class="empty-state-title">No Inquiries Submitted</h3>
                        <p class="empty-state-text">Need assistance, a feature extension, or a new project quote? Send us a request.</p>
                        <a href="{{ route('client.leads.create') }}" class="btn-primary">
                            <i class="bi bi-pencil-square"></i>
                            <span>Submit Request</span>
                        </a>
                    </div>
                @else
                    <div class="portal-table-wrap">
                        <table class="portal-table">
                            <thead>
                                <tr>
                                    <th>Subject / Date</th>
                                    <th>Services</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($recentLeads as $lead)
                                    <tr>
                                        <td>
                                            <div style="font-weight: 600; color: var(--cp-dark); font-size: 0.88rem;">
                                                {{ Str::limit($lead->message, 38) }}
                                            </div>
                                            <div style="font-size: 0.75rem; color: var(--cp-ink-muted); margin-top: 2px;">
                                                {{ $lead->created_at->format('M d, Y') }}
                                            </div>
                                        </td>
                                        <td>
                                            @if ($lead->services->isNotEmpty())
                                                <span class="service-chip">
                                                    {{ $lead->services->first()->name }}
                                                    @if ($lead->services->count() > 1)
                                                        +{{ $lead->services->count() - 1 }}
                                                    @endif
                                                </span>
                                            @else
                                                <span style="font-size: 0.78rem; color: var(--cp-ink-subtle);">General</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="status-badge status-badge-{{ $lead->status->value }}">
                                                {{ $lead->status->label() }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
