@extends('client.layouts.client-master')

@section('title', 'Inquiries & Proposals')
@section('page_title', 'Inquiries & Proposals')
@section('breadcrumb_current', 'Inquiries')

@section('content')
    <!-- Top Action Bar -->
    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px; flex-wrap: wrap; gap: 16px;">
        <div>
            <h2 style="font-size: 1.15rem; font-weight: 700; color: var(--cp-dark);">Inquiries & Project Requests</h2>
            <p style="font-size: 0.82rem; color: var(--cp-ink-muted);">Keep track of all project scopes and quote requests submitted to PenSoftTech.</p>
        </div>

        <a href="{{ route('client.leads.create') }}" class="btn-primary">
            <i class="bi bi-plus-lg"></i>
            <span>Submit New Request</span>
        </a>
    </div>

    <!-- Leads Table / Listing -->
    <div class="portal-card">
        @if ($leads->isEmpty())
            <div class="empty-state">
                <div class="empty-state-icon">
                    <i class="bi bi-chat-left-dots"></i>
                </div>
                <h3 class="empty-state-title">No Inquiries Yet</h3>
                <p class="empty-state-text">
                    You haven't submitted any service or project inquiries yet. Ready to start something new?
                </p>
                <a href="{{ route('client.leads.create') }}" class="btn-primary">
                    <i class="bi bi-pencil-square"></i>
                    <span>Submit Your First Request</span>
                </a>
            </div>
        @else
            <div class="portal-table-wrap">
                <table class="portal-table">
                    <thead>
                        <tr>
                            <th>Inquiry Details</th>
                            <th>Target Services</th>
                            <th>Est. Budget</th>
                            <th>Submitted On</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($leads as $lead)
                            <tr>
                                <td style="max-width: 320px;">
                                    <div style="font-weight: 700; color: var(--cp-dark); font-size: 0.9rem; margin-bottom: 4px;">
                                        {{ Str::limit($lead->message, 45) }}
                                    </div>
                                    <div style="font-size: 0.8rem; color: var(--cp-ink-muted); line-height: 1.4;">
                                        {{ Str::limit(str_replace(["\r", "\n"], ' ', $lead->message), 80) }}
                                    </div>
                                </td>
                                <td>
                                    @if ($lead->services->isNotEmpty())
                                        <div style="display: flex; flex-wrap: wrap; gap: 4px;">
                                            @foreach ($lead->services as $service)
                                                <span class="service-chip">{{ $service->name }}</span>
                                            @endforeach
                                        </div>
                                    @else
                                        <span style="font-size: 0.82rem; color: var(--cp-ink-subtle);">General Consulting</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($lead->budget)
                                        <span style="font-weight: 600; color: var(--cp-dark); font-size: 0.88rem;">
                                            ${{ number_format($lead->budget, 2) }}
                                        </span>
                                    @else
                                        <span style="font-size: 0.82rem; color: var(--cp-ink-subtle);">To be discussed</span>
                                    @endif
                                </td>
                                <td>
                                    <div style="font-size: 0.86rem; color: var(--cp-ink);">
                                        {{ $lead->created_at->format('M d, Y') }}
                                    </div>
                                    <div style="font-size: 0.74rem; color: var(--cp-ink-muted);">
                                        {{ $lead->created_at->diffForHumans() }}
                                    </div>
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

            @if ($leads->hasPages())
                <div style="padding: 16px 24px; border-top: 1px solid var(--cp-border-light);">
                    {{ $leads->links() }}
                </div>
            @endif
        @endif
    </div>
@endsection
