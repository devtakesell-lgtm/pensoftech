@extends('admin.layouts.admin-master')

@section('title', 'Lead Dossier — ' . $lead->name)

@section('content')
    {{-- Back Link & Section Info --}}
    <div class="mb-3">
        <a href="{{ route('admin.leads') }}" class="btn light btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Back to Leads Pipeline
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
        $initials = collect(explode(' ', $lead->name))
            ->map(fn($w) => mb_substr($w, 0, 1))
            ->take(2)
            ->join('');
    @endphp

    {{-- Hero Dossier Header --}}
    <div class="dossier-hero">
        <div class="dossier-hero-title">
            <div class="dossier-avatar-large">
                {{ strtoupper($initials ?: 'L') }}
            </div>
            <div class="dossier-hero-info">
                <h2>
                    {{ $lead->name }}
                    @if ($lead->isConvertedClient())
                        <x-verified-badge title="Official Converted Client" :url="route('admin.clients')" />
                    @endif
                </h2>
                <p>
                    @if ($lead->company_name)
                        <i class="bi bi-building me-1"></i> <strong>{{ $lead->company_name }}</strong> &bull;
                    @endif
                    <span>Inquiry created {{ $lead->created_at->format('M d, Y') }}</span>
                    @if ($lead->industry)
                        &bull; <span class="badge bg-light text-dark border">{{ $lead->industry->name }}</span>
                    @endif
                </p>
            </div>
        </div>

        <div class="dossier-hero-actions">
            {{-- Status Badge --}}
            <span class="status-badge {{ $lead->status->badgeClass() }} fs-6 py-2 px-3">
                <i class="bi {{ $lead->status->icon() }} me-1"></i> {{ $lead->status->label() }}
            </span>

            {{-- Smart Action Buttons based on lifecycle stage --}}
            @if ($lead->client_id)
                {{-- 1. Already Converted --}}
                <span class="btn light disabled text-success fw-bold">
                    <i class="bi bi-patch-check-fill me-1"></i> Converted Client
                </span>
                <a href="{{ route('admin.clients') }}" class="btn primary">
                    <i class="bi bi-building me-1"></i> View Client Profile
                </a>
            @elseif ($lead->status === \App\Enums\LeadStatus::Converted && !$lead->client_id)
                {{-- 2. Ready to Convert to Client --}}
                @can('edit-leads')
                    <button type="button" class="btn primary" data-bs-toggle="modal" data-bs-target="#convertLeadModal">
                        <i class="bi bi-person-check-fill me-1"></i> Convert to Client
                    </button>
                @endcan
            @elseif ($lead->status === \App\Enums\LeadStatus::Lost)
                {{-- 3. Deal Lost: Smart Reopen Button --}}
                @can('edit-leads')
                    <form action="{{ route('admin.leads.update-status', $lead) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="new">
                        <button type="submit" class="btn light text-primary" title="Re-open lead into active pipeline">
                            <i class="bi bi-arrow-counterclockwise me-1"></i> Reopen Lead
                        </button>
                    </form>
                @endcan
            @else
                {{-- 4. Active Stages: Smart Next Step CTA --}}
                @can('edit-leads')
                    @if ($lead->status === \App\Enums\LeadStatus::New)
                        <form action="{{ route('admin.leads.update-status', $lead) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="contacted">
                            <button type="submit" class="btn primary">
                                <i class="bi bi-telephone-forward me-1"></i> Mark Contacted
                            </button>
                        </form>
                    @elseif ($lead->status === \App\Enums\LeadStatus::Contacted)
                        <form action="{{ route('admin.leads.update-status', $lead) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="qualified">
                            <button type="submit" class="btn primary">
                                <i class="bi bi-patch-check me-1"></i> Mark Qualified
                            </button>
                        </form>
                    @elseif (in_array($lead->status, [\App\Enums\LeadStatus::Qualified, \App\Enums\LeadStatus::ProposalSent]))
                        @can('create-quotes')
                            <button type="button" class="btn primary" data-bs-toggle="modal" data-bs-target="#createQuoteModal">
                                <i class="bi bi-file-earmark-plus me-1"></i> Create Quote
                            </button>
                        @endcan
                    @endif

                    @if (
                        $lead->status === \App\Enums\LeadStatus::ProposalSent &&
                            !$lead->client_id &&
                            $lead->quotes->contains('status', \App\Enums\QuoteStatus::Accepted))
                        @can('edit-leads')
                            <button type="button" class="btn primary" data-bs-toggle="modal" data-bs-target="#convertLeadModal">
                                <i class="bi bi-person-check-fill me-1"></i> Convert to Client
                            </button>
                        @endcan
                    @endif
                @endcan
            @endif



            {{-- Edit Button --}}
            @can('edit-leads')
                <a href="{{ route('admin.leads.edit', $lead) }}" class="btn light">
                    <i class="bi bi-pencil-square me-1"></i> Edit
                </a>
            @endcan

            {{-- Delete Button --}}
            @can('delete-leads')
                <form action="{{ route('admin.leads.destroy', $lead) }}" method="POST" class="d-inline"
                    onsubmit="return confirm('Are you sure you want to delete this lead?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn light text-danger" title="Delete Lead">
                        <i class="bi bi-trash3"></i>
                    </button>
                </form>
            @endcan
        </div>
    </div>

    {{-- Visual Sales Pipeline Stepper --}}
    @php
        $pipelineStages = [
            \App\Enums\LeadStatus::New,
            \App\Enums\LeadStatus::Contacted,
            \App\Enums\LeadStatus::Qualified,
            \App\Enums\LeadStatus::ProposalSent,
            \App\Enums\LeadStatus::Converted,
        ];
        $isLost = $lead->status === \App\Enums\LeadStatus::Lost;
        $currentStageIndex = array_search($lead->status, $pipelineStages);
        if ($currentStageIndex === false) {
            $currentStageIndex = -1;
        }
    @endphp

    <div class="lead-pipeline-wrapper">
        <div class="lead-pipeline-topbar">
            <h4 class="lead-pipeline-title">
                <i class="bi bi-diagram-3-fill text-primary"></i> Deal Lifecycle & Pipeline Stage
            </h4>
            <div class="lead-pipeline-actions">
                @if (!$isLost && !$lead->client_id && $lead->status !== \App\Enums\LeadStatus::Converted)
                    @can('edit-leads')
                        <form action="{{ route('admin.leads.update-status', $lead) }}" method="POST" class="d-inline"
                            onsubmit="return confirm('Mark this lead as lost/dropped?');">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="lost">
                            <button type="submit" class="btn light btn-sm text-danger" title="Mark deal as lost">
                                <i class="bi bi-x-circle me-1"></i> Mark as Lost
                            </button>
                        </form>
                    @endcan
                @endif
            </div>
        </div>

        <div class="lead-pipeline-stepper">
            @foreach ($pipelineStages as $index => $stage)
                @php
                    $isCompleted = !$isLost && $currentStageIndex > $index;
                    $isCurrent = !$isLost && $currentStageIndex === $index;
                    $isUpcoming = !$isLost && $currentStageIndex < $index;

                    $stepClass = $isCurrent ? 'is-current' : ($isCompleted ? 'is-completed' : 'is-upcoming');
                @endphp

                @can('edit-leads')
                    @php
                        $isDisabled = $isCurrent;
                        // Prevent moving back to ANY previous stage unless it's Lost
                        if (!$isLost && $isCompleted) {
                            $isDisabled = true;
                        }
                    @endphp
                    <form action="{{ route('admin.leads.update-status', $lead) }}" method="POST" class="pipeline-step-form">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="{{ $stage->value }}">
                        <button type="submit" class="pipeline-step {{ $stepClass }}" {{ $isDisabled ? 'disabled' : '' }}
                            title="{{ $isCurrent ? 'Current stage' : ($isDisabled ? 'Cannot revert to this stage' : 'Move stage to ' . $stage->label()) }}">
                            <div class="step-indicator">
                                @if ($isCompleted)
                                    <i class="bi bi-check-lg"></i>
                                @else
                                    {{ $index + 1 }}
                                @endif
                            </div>
                            <div class="step-details">
                                <span class="step-label">{{ $stage->label() }}</span>
                                <span class="step-subtext">
                                    @if ($isCurrent)
                                        Active Stage
                                    @elseif ($isCompleted)
                                        Completed
                                    @else
                                        Advance to stage
                                    @endif
                                </span>
                            </div>
                        </button>
                    </form>
                @else
                    <div class="pipeline-step {{ $stepClass }}">
                        <div class="step-indicator">
                            @if ($isCompleted)
                                <i class="bi bi-check-lg"></i>
                            @else
                                {{ $index + 1 }}
                            @endif
                        </div>
                        <div class="step-details">
                            <span class="step-label">{{ $stage->label() }}</span>
                            <span class="step-subtext">
                                @if ($isCurrent)
                                    Active Stage
                                @elseif ($isCompleted)
                                    Completed
                                @else
                                    Upcoming
                                @endif
                            </span>
                        </div>
                    </div>
                @endcan
            @endforeach
        </div>

        {{-- Lost Banner if current status is Lost --}}
        @if ($isLost)
            <div class="lead-pipeline-lost-banner">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-x-circle-fill fs-5 text-danger"></i>
                    <div>
                        <strong class="text-danger">Deal Closed — Lost</strong>
                        <span class="text-muted ms-2 small">This inquiry is currently marked as dropped or unviable.</span>
                    </div>
                </div>
                @can('edit-leads')
                    <form action="{{ route('admin.leads.update-status', $lead) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="new">
                        <button type="submit" class="btn light btn-sm text-primary">
                            <i class="bi bi-arrow-counterclockwise me-1"></i> Re-open as Active Inquiry
                        </button>
                    </form>
                @endcan
            </div>
        @endif
    </div>

    {{-- Dossier Content Grid --}}
    <div class="dossier-grid">
        {{-- Left Column: Project Details & Requirements --}}
        <div>
            {{-- Client Inquiry / Requirements Brief --}}
            <div class="dossier-card">
                <h3 class="dossier-card-title">
                    <i class="bi bi-chat-left-quote-fill text-primary"></i> Project Brief & Requirements
                </h3>
                @if ($lead->message)
                    <div class="dossier-message-box">
                        {{ $lead->message }}
                    </div>
                @else
                    <p class="text-muted fst-italic">No initial description or notes provided.</p>
                @endif
            </div>

            {{-- Interested Services --}}
            <div class="dossier-card">
                <h3 class="dossier-card-title">
                    <i class="bi bi-layers-fill text-primary"></i> Interested Agency Services
                </h3>
                @if ($lead->services->isNotEmpty())
                    <div class="d-flex flex-wrap gap-2">
                        @foreach ($lead->services as $service)
                            <div class="p-2 px-3 border rounded bg-light d-flex align-items-center gap-2">
                                <i class="bi {{ $service->icon ?: 'bi-check-circle' }} text-primary"></i>
                                <span class="fw-semibold text-dark">{{ $service->name }}</span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted fst-italic">No specific services selected.</p>
                @endif
            </div>

            {{-- Associated Quotes --}}
            <div class="dossier-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h3 class="dossier-card-title mb-0">
                        <i class="bi bi-file-earmark-text-fill text-primary"></i> Estimates & Proposals
                        <span class="badge bg-light text-primary border ms-2">{{ $lead->quotes->count() }}</span>
                    </h3>

                    @if (in_array($lead->status, [\App\Enums\LeadStatus::Qualified, \App\Enums\LeadStatus::ProposalSent]))
                        @can('create-quotes')
                            <button class="btn primary btn-sm" data-bs-toggle="modal" data-bs-target="#createQuoteModal">
                                <i class="bi bi-plus-lg me-1"></i> New Quote
                            </button>
                        @endcan
                    @endif
                </div>

                @if ($lead->quotes->isNotEmpty())
                    <div class="tablewrap">
                        <table>
                            <thead>
                                <tr>
                                    <th>QUOTE / TITLE</th>
                                    <th>SERVICES</th>
                                    <th>ESTIMATED BUDGET</th>
                                    <th>STATUS</th>
                                    <th>VALID UNTIL</th>
                                    <th class="text-end">ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($lead->quotes as $quote)
                                    @php
                                        $sym = $quote->currency?->symbol ?? ($defaultCurrency?->symbol ?? '$');
                                        $currencyCode = $quote->currency?->code ?? ($defaultCurrency?->code ?? 'USD');
                                    @endphp
                                    <tr>
                                        <td>
                                            <a href="{{ route('admin.quotes.show', $quote) }}"
                                                class="text-decoration-none fw-bold text-dark">
                                                <span
                                                    class="font-monospace text-muted small me-1">{{ $quote->quote_number ?? 'QUOTE-' . $quote->id }}</span><br>
                                                {{ $quote->title }}
                                            </a>
                                            <div class="small text-muted mt-1">
                                                Created {{ $quote->created_at->format('M d, Y') }} by
                                                {{ $quote->creator?->name ?? 'System' }}
                                            </div>
                                        </td>
                                        <td>
                                            @if ($quote->services->count() > 0)
                                                <span
                                                    class="badge bg-light text-dark border">{{ $quote->services->count() }}
                                                    Items</span>
                                            @else
                                                <span class="text-muted">—</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="lead-budget-text fw-semibold">
                                                @if ($quote->budget_min && $quote->budget_max)
                                                    {{ $sym }}{{ number_format($quote->budget_min, 0) }} –
                                                    {{ $sym }}{{ number_format($quote->budget_max, 0) }} <span
                                                        class="small text-muted">{{ $currencyCode }}</span>
                                                @elseif ($quote->budget_max)
                                                    {{ $sym }}{{ number_format($quote->budget_max, 0) }} <span
                                                        class="small text-muted">{{ $currencyCode }}</span>
                                                @elseif ($quote->budget_min)
                                                    {{ $sym }}{{ number_format($quote->budget_min, 0) }} <span
                                                        class="small text-muted">{{ $currencyCode }}</span>
                                                @else
                                                    <span class="text-muted">—</span>
                                                @endif
                                            </span>
                                        </td>
                                        <td>
                                            @if (in_array($quote->status, [\App\Enums\QuoteStatus::Draft, \App\Enums\QuoteStatus::Sent]) &&
                                                    auth()->user()->can('edit-quotes'))
                                                <form action="{{ route('admin.quotes.update-status', $quote) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <select name="status" onchange="this.form.submit()"
                                                        class="lead-status-select p-2">
                                                        @foreach ($quote->status->allowedTransitions() as $allowedStatus)
                                                            <option value="{{ $allowedStatus->value }}"
                                                                {{ $quote->status === $allowedStatus ? 'selected' : '' }}>
                                                                {{ $allowedStatus->label() }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </form>
                                            @else
                                                <span class="status-badge {{ $quote->status->badgeClass() }}">
                                                    <i class="bi {{ $quote->status->icon() }} me-1"></i>
                                                    {{ $quote->status->label() }}
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($quote->valid_until)
                                                <span
                                                    class="{{ $quote->valid_until->isPast() ? 'text-danger fw-semibold' : '' }}">
                                                    {{ $quote->valid_until->format('M d, Y') }}
                                                    @if ($quote->valid_until->isPast())
                                                        <i class="bi bi-exclamation-circle ms-1" title="Expired"></i>
                                                    @endif
                                                </span>
                                            @else
                                                <span class="text-muted">—</span>
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            <a href="{{ route('admin.quotes.show', $quote) }}" class="btn light btn-sm"
                                                title="View Quote">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            @can('edit-quotes')
                                                <a href="{{ route('admin.quotes.edit', $quote) }}" class="btn light btn-sm"
                                                    title="Edit Quote">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                            @endcan
                                            @can('delete-quotes')
                                                <form action="{{ route('admin.quotes.destroy', $quote) }}" method="POST"
                                                    class="d-inline" onsubmit="return confirm('Delete this quote?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn light btn-sm text-danger"
                                                        title="Delete Quote">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5 bg-light rounded border-dashed mt-3" style="border: 2px dashed #dee2e6;">
                        <i class="bi bi-file-earmark-text text-muted fs-1 mb-2"></i>
                        <h5 class="text-dark fw-semibold">No Quotes Yet</h5>
                        <p class="text-muted mb-3">There are no estimates or proposals associated with this lead.</p>

                        @if (in_array($lead->status, [\App\Enums\LeadStatus::Qualified, \App\Enums\LeadStatus::ProposalSent]))
                            @can('create-quotes')
                                <button class="btn primary" data-bs-toggle="modal" data-bs-target="#createQuoteModal">
                                    <i class="bi bi-plus-lg me-1"></i> Create First Quote
                                </button>
                            @endcan
                        @endif
                    </div>
                @endif
            </div>

            {{-- Marketing Attribution Details --}}
            <div class="dossier-card">
                <h3 class="dossier-card-title">
                    <i class="bi bi-bullseye text-primary"></i> Acquisition & Marketing Attribution
                </h3>
                @php
                    $hasUtm =
                        $lead->utm_source ||
                        $lead->utm_medium ||
                        $lead->utm_campaign ||
                        $lead->utm_content ||
                        $lead->gclid ||
                        $lead->fbclid ||
                        $lead->ip_address;
                @endphp

                @if ($hasUtm)
                    <div class="utm-tag-list">
                        @if ($lead->utm_source)
                            <span class="utm-tag">source: <strong>{{ $lead->utm_source }}</strong></span>
                        @endif
                        @if ($lead->utm_medium)
                            <span class="utm-tag">medium: <strong>{{ $lead->utm_medium }}</strong></span>
                        @endif
                        @if ($lead->utm_campaign)
                            <span class="utm-tag">campaign: <strong>{{ $lead->utm_campaign }}</strong></span>
                        @endif
                        @if ($lead->utm_content)
                            <span class="utm-tag">content: <strong>{{ $lead->utm_content }}</strong></span>
                        @endif
                        @if ($lead->gclid)
                            <span class="utm-tag">gclid: <strong>{{ Str::limit($lead->gclid, 15) }}</strong></span>
                        @endif
                        @if ($lead->fbclid)
                            <span class="utm-tag">fbclid: <strong>{{ Str::limit($lead->fbclid, 15) }}</strong></span>
                        @endif
                        @if ($lead->ip_address)
                            <span class="utm-tag">ip: <strong>{{ $lead->ip_address }}</strong></span>
                        @endif
                    </div>
                @else
                    <p class="text-muted fst-italic">No digital campaign tracking parameters logged for this lead.</p>
                @endif
            </div>
        </div>

        {{-- Right Column: Deal Overview & Key Parameters --}}
        <div>
            {{-- Deal Commercials --}}
            <div class="dossier-card">
                <h3 class="dossier-card-title">
                    <i class="bi bi-cash-stack text-primary"></i> Deal Financials
                </h3>
                <div class="dossier-data-row">
                    <span class="dossier-label">Estimated Budget</span>
                    <span class="dossier-value text-success fs-5">
                        @if ($lead->budget)
                            {{ $lead->currency?->symbol ?? ($defaultCurrency?->symbol ?? '$') }}{{ number_format($lead->budget, 2) }}
                            <small
                                class="text-muted fs-6">({{ $lead->currency?->code ?? ($defaultCurrency?->code ?? 'USD') }})</small>
                        @else
                            <span class="text-muted fs-6">Unspecified</span>
                        @endif
                    </span>
                </div>
                <div class="dossier-data-row">
                    <span class="dossier-label">Acquisition Channel</span>
                    <span class="dossier-value">
                        <span class="lead-source-pill">
                            {{ ucfirst(str_replace('_', ' ', $lead->lead_source ?? 'Direct')) }}
                        </span>
                    </span>
                </div>
                <div class="dossier-data-row">
                    <span class="dossier-label">Project Type</span>
                    <span class="dossier-value">
                        {{ ucfirst(str_replace('_', ' ', $lead->lead_type ?? 'Standard Project')) }}
                    </span>
                </div>
            </div>

            {{-- Contact Information --}}
            <div class="dossier-card">
                <h3 class="dossier-card-title">
                    <i class="bi bi-telephone-fill text-primary"></i> Direct Contact Info
                </h3>
                <div class="dossier-data-row">
                    <span class="dossier-label">Primary Contact</span>
                    <span class="dossier-value">{{ $lead->name }}</span>
                </div>
                <div class="dossier-data-row">
                    <span class="dossier-label">Company</span>
                    <span class="dossier-value">{{ $lead->company_name ?? '—' }}</span>
                </div>
                <div class="dossier-data-row">
                    <span class="dossier-label">Email</span>
                    <span class="dossier-value">
                        @if ($lead->email)
                            <a href="mailto:{{ $lead->email }}" class="text-decoration-none">
                                {{ $lead->email }}
                            </a>
                        @else
                            —
                        @endif
                    </span>
                </div>
                <div class="dossier-data-row">
                    <span class="dossier-label">Phone</span>
                    <span class="dossier-value">
                        @if ($lead->phone)
                            <a href="tel:{{ $lead->phone }}" class="text-decoration-none">
                                {{ $lead->phone }}
                            </a>
                        @else
                            —
                        @endif
                    </span>
                </div>
                <div class="dossier-data-row">
                    <span class="dossier-label">Website</span>
                    <span class="dossier-value">
                        @if ($lead->website)
                            <a href="{{ Str::startsWith($lead->website, 'http') ? $lead->website : 'https://' . $lead->website }}"
                                target="_blank" rel="noopener noreferrer" class="text-decoration-none">
                                {{ Str::limit($lead->website, 25) }} <i class="bi bi-box-arrow-up-right small"></i>
                            </a>
                        @else
                            —
                        @endif
                    </span>
                </div>
            </div>

            {{-- Assignment & Ownership --}}
            <div class="dossier-card">
                <h3 class="dossier-card-title">
                    <i class="bi bi-person-badge-fill text-primary"></i> Team Assignment
                </h3>
                <div class="dossier-data-row">
                    <span class="dossier-label">Account Owner</span>
                    {{-- Quick Status Changer Dropdown --}}
                    @can('edit-leads')
                        <span class="dossier-value">
                            <form action="{{ route('admin.leads.assignee', $lead) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <select name="assignee_to" onchange="this.form.submit()" class="lead-status-select p-2">
                                    <option value="">Unassigned </option>
                                    @foreach ($assignees ?? [] as $assignee)
                                        <option value="{{ $assignee->id }}"
                                            {{ (string) old('assignee_to', $lead->assigned_to) === (string) $assignee->id ? 'selected' : '' }}>
                                            {{ $assignee->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </form>
                        </span>
                    @else
                        <span class="dossier-value">
                            @if ($lead->assignee)
                                <div class="d-flex align-items-center gap-2 justify-content-end">
                                    <i class="bi bi-person-check-fill text-primary"></i>
                                    <span>{{ $lead->assignee->name }}</span>
                                </div>
                            @else
                                <span class="text-muted fst-italic">Unassigned</span>
                            @endif
                        </span>
                    @endcan

                </div>
                <div class="dossier-data-row">
                    <span class="dossier-label">Created At</span>
                    <span class="dossier-value">{{ $lead->created_at->format('M d, Y h:i A') }}</span>
                </div>
                <div class="dossier-data-row">
                    <span class="dossier-label">Last Updated</span>
                    <span class="dossier-value">{{ $lead->updated_at->diffForHumans() }}</span>
                </div>
            </div>

            {{-- Converted Client Link if exists --}}
            @if ($lead->client)
                <div class="dossier-card border-success">
                    <h3 class="dossier-card-title text-success">
                        <i class="bi bi-building-check"></i> Linked Client Record
                    </h3>
                    <div class="dossier-data-row">
                        <span class="dossier-label">Client Name</span>
                        <span class="dossier-value fw-bold">{{ $lead->client->company_name }}</span>
                    </div>
                    <div class="dossier-data-row">
                        <span class="dossier-label">Contact Person</span>
                        <span class="dossier-value">{{ $lead->client->contact_person }}</span>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('admin.clients') }}" class="btn light btn-sm w-100">
                            <i class="bi bi-arrow-right me-1"></i> View Clients Directory
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- Create Quote Modal --}}
    @can('create-quotes')
        @include('admin.components.modals.quote-create-modal')
    @endcan

    {{-- Convert to Client Modal --}}
    @if ($lead->status === \App\Enums\LeadStatus::ProposalSent && !$lead->client_id)
        @can('edit-leads')
            @include('admin.components.modals.client-create-modal', [
                'formAction' => route('admin.leads.convert', $lead),
                'modalId' => 'convertLeadModal',
                'title' => 'Convert to Client Profile',
                'description' =>
                    'This will create a new Client record and a linked User account. A random password will be generated and emailed to the client automatically.',
                'submitText' => 'Convert to Client',
                'defaultContactPerson' => $lead->name,
                'defaultEmail' => $lead->email,
                'defaultCompanyName' => $lead->company_name ?: $lead->name,
                'defaultPhone' => $lead->phone,
                'defaultWebsite' => $lead->website,
            ])
        @endcan
    @endif
@endsection
