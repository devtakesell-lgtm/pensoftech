@extends('admin.layouts.admin-master')

@section('title', 'Leads Management')

@section('content')
    {{-- Page Header --}}
    <div class="heading">
        <div>
            <small>AGENCY ADMIN</small>
            <h1>Leads & Pipeline</h1>
            <p>Track potential clients, customer inquiries, qualification statuses, and project deal opportunities.</p>
        </div>
        <div>
            @can('create-leads')
                <a href="{{ route('admin.leads.create') }}" class="btn primary">
                    <i class="bi bi-plus-lg me-1"></i> Add Lead
                </a>
            @endcan
        </div>
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

    {{-- Pipeline KPI Cards --}}
    <div class="lead-stats-grid">
        <div class="lead-stat-card">
            <div class="lead-stat-icon icon-primary">
                <i class="bi bi-people-fill"></i>
            </div>
            <div class="lead-stat-content">
                <h4>{{ number_format($totalCount) }}</h4>
                <span>Total Leads</span>
            </div>
        </div>

        <div class="lead-stat-card">
            <div class="lead-stat-icon icon-info">
                <i class="bi bi-stars"></i>
            </div>
            <div class="lead-stat-content">
                <h4>{{ number_format($newCount) }}</h4>
                <span>New Inquiries</span>
            </div>
        </div>

        <div class="lead-stat-card">
            <div class="lead-stat-icon icon-warning">
                <i class="bi bi-patch-check-fill"></i>
            </div>
            <div class="lead-stat-content">
                <h4>{{ number_format($qualifiedCount) }}</h4>
                <span>Qualified Deals</span>
            </div>
        </div>

        <div class="lead-stat-card">
            <div class="lead-stat-icon icon-success">
                <i class="bi bi-trophy-fill"></i>
            </div>
            <div class="lead-stat-content">
                <h4>{{ number_format($convertedCount) }}</h4>
                <span>Won / Converted</span>
            </div>
        </div>

        <div class="lead-stat-card">
            <div class="lead-stat-icon icon-value">
                <i class="bi bi-currency-dollar"></i>
            </div>
            <div class="lead-stat-content">
                <h4>{{ $defaultCurrency?->symbol ?? '$' }}{{ number_format($activePipelineValue ?? 0.0, 0) }}</h4>
                <span>Pipeline Value</span>
            </div>
        </div>
    </div>

    {{-- Leads Table Card --}}
    <div class="card list-card">
        {{-- Search & Filters --}}
        <div class="toolbar">
            <form method="GET" action="{{ route('admin.leads') }}" class="toolbar-filters flex-wrap">
                <input type="text" name="search" value="{{ $currentSearch ?? '' }}"
                    placeholder="Search name, company, email, phone..." class="filter-search-input">

                <select name="status" onchange="this.form.submit()" class="filter-select">
                    <option value="">All Statuses</option>
                    @foreach ($statuses ?? [] as $status)
                        <option value="{{ $status->value }}"
                            {{ ($currentStatus ?? '') === $status->value ? 'selected' : '' }}>
                            {{ $status->label() }}
                        </option>
                    @endforeach
                </select>

                <select name="source" onchange="this.form.submit()" class="filter-select">
                    <option value="">All Sources</option>
                    @foreach ($sources ?? [] as $sourceKey => $sourceLabel)
                        <option value="{{ $sourceKey }}" {{ ($currentSource ?? '') === $sourceKey ? 'selected' : '' }}>
                            {{ $sourceLabel }}
                        </option>
                    @endforeach
                </select>

                <select name="industry_id" onchange="this.form.submit()" class="filter-select">
                    <option value="">All Industries</option>
                    @foreach ($industries ?? [] as $industry)
                        <option value="{{ $industry->id }}"
                            {{ (string) ($currentIndustry ?? '') === (string) $industry->id ? 'selected' : '' }}>
                            {{ $industry->name }}
                        </option>
                    @endforeach
                </select>

                <select name="assigned_to" onchange="this.form.submit()" class="filter-select">
                    <option value="">All Assignees</option>
                    @foreach ($assignees ?? [] as $assignee)
                        <option value="{{ $assignee->id }}"
                            {{ (string) ($currentAssignee ?? '') === (string) $assignee->id ? 'selected' : '' }}>
                            {{ $assignee->name }}
                        </option>
                    @endforeach
                </select>

                <button type="submit" class="btn light">Filter</button>

                @if (
                    !empty($currentSearch) ||
                        !empty($currentStatus) ||
                        !empty($currentSource) ||
                        !empty($currentIndustry) ||
                        !empty($currentAssignee))
                    <a href="{{ route('admin.leads') }}" class="btn light filter-btn-reset">
                        Reset
                    </a>
                @endif
            </form>
        </div>

        <div class="tablewrap">
            <table>
                <thead>
                    <tr>
                        <th class="col-lead-contact">LEAD / CONTACT</th>
                        <th>INTERESTED SERVICES</th>
                        <th>EST. BUDGET</th>
                        <th>SOURCE</th>
                        <th>ASSIGNED TO</th>
                        <th>STATUS</th>
                        <th>DATE</th>
                        <th class="text-end-align">ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($leads ?? [] as $lead)
                        @php
                            $initials = collect(explode(' ', $lead->name))
                                ->map(fn($w) => mb_substr($w, 0, 1))
                                ->take(2)
                                ->join('');
                        @endphp
                        <tr>
                            <td>
                                <div class="lead-cell-contact">
                                    <div class="lead-avatar-circle">
                                        {{ strtoupper($initials ?: 'L') }}
                                    </div>
                                    <div class="lead-name-box">
                                        <div class="d-inline-flex align-items-center gap-1">
                                            <a href="{{ route('admin.leads.show', $lead) }}" class="text-decoration-none">
                                                <strong>{{ $lead->name }}</strong>
                                            </a>
                                            @if ($lead->isConvertedClient())
                                                <x-verified-badge title="Converted Client Account" :url="route('admin.clients')" />
                                            @endif
                                        </div>
                                        @if ($lead->company_name)
                                            <span class="lead-company">
                                                <i class="bi bi-building me-1"></i>{{ $lead->company_name }}
                                            </span>
                                        @endif
                                        <div class="lead-contact-meta">
                                            @if ($lead->email)
                                                <a href="mailto:{{ $lead->email }}" class="lead-contact-item"
                                                    title="{{ $lead->email }}">
                                                    <i class="bi bi-envelope"></i>
                                                    <span class="lead-contact-text">{{ $lead->email }}</span>
                                                </a>
                                            @endif
                                            @if ($lead->phone)
                                                <a href="tel:{{ $lead->phone }}" class="lead-contact-item"
                                                    title="{{ $lead->phone }}">
                                                    <i class="bi bi-telephone"></i>
                                                    <span class="lead-contact-text">{{ $lead->phone }}</span>
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="lead-services-wrap">
                                    @forelse($lead->services as $service)
                                        <span class="lead-service-tag">{{ $service->name }}</span>
                                    @empty
                                        <span class="text-muted small">General Inquiry</span>
                                    @endforelse
                                </div>
                            </td>
                            <td>
                                @if ($lead->budget)
                                    <span class="lead-budget-text">
                                        {{ $lead->currency?->symbol ?? ($defaultCurrency?->symbol ?? '$') }}{{ number_format($lead->budget, 0) }}
                                    </span>
                                    <span
                                        class="lead-budget-currency">{{ $lead->currency?->code ?? ($defaultCurrency?->code ?? 'USD') }}</span>
                                @else
                                    <span class="text-muted small">—</span>
                                @endif
                            </td>
                            <td>
                                <span class="lead-source-pill">
                                    <i class="bi bi-arrow-up-right-circle"></i>
                                    {{ $sources[$lead->lead_source] ?? ucfirst(str_replace('_', ' ', $lead->lead_source ?? 'Direct')) }}
                                </span>
                            </td>
                            <td>
                                @if ($lead->assignee)
                                    <span class="d-inline-flex align-items-center gap-1 text-secondary fw-semibold small">
                                        <i class="bi bi-person-check text-primary"></i> {{ $lead->assignee->name }}
                                    </span>
                                @else
                                    <span class="text-muted small italic">Unassigned</span>
                                @endif
                            </td>
                            <td>
                                @if (in_array($lead->status, $initialCases, true))
                                    @can('edit-leads')
                                        <form action="{{ route('admin.leads.update-status', $lead) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <select name="status" 
                                                data-original="{{ $lead->status->value }}"
                                                onchange="if(confirm('Are you sure you want to change this lead\'s status?')) { this.form.submit(); } else { this.value = this.getAttribute('data-original'); }"
                                                class="lead-status-select {{ $lead->status->badgeClass() }}">
                                                @php
                                                    $pipelineStages = [
                                                        \App\Enums\LeadStatus::New->value,
                                                        \App\Enums\LeadStatus::Contacted->value,
                                                        \App\Enums\LeadStatus::Qualified->value,
                                                    ];
                                                    $currentIndex = array_search($lead->status->value, $pipelineStages);
                                                @endphp
                                                @foreach ($initialCases ?? [] as $statusOption)
                                                    @php
                                                        $optionIndex = array_search(
                                                            $statusOption->value,
                                                            $pipelineStages,
                                                        );
                                                        $isDisabled =
                                                            $lead->status !== \App\Enums\LeadStatus::Lost &&
                                                            $currentIndex !== false &&
                                                            $optionIndex !== false &&
                                                            $optionIndex < $currentIndex;
                                                    @endphp
                                                    <option value="{{ $statusOption->value }}"
                                                        {{ $lead->status->value === $statusOption->value ? 'selected' : '' }}
                                                        {{ $isDisabled ? 'disabled' : '' }}>
                                                        {{ $statusOption->label() }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </form>
                                    @endcan
                                @else
                                    <span class="status-badge {{ $lead->status->badgeClass() }}">
                                        <i class="bi {{ $lead->status->icon() }} me-1"></i>
                                        {{ $lead->status->label() }}
                                    </span>
                                @endif
                                {{-- @endcan --}}
                            </td>
                            <td>
                                <span class="fw-semibold text-dark small d-block">
                                    {{ $lead->created_at->format('M d, Y') }}
                                </span>
                                <small class="text-muted">{{ $lead->created_at->diffForHumans() }}</small>
                            </td>
                            <td class="text-end-align nowrap-cell">
                                <div class="table-actions">
                                    @can('view-leads')
                                        <a href="{{ route('admin.leads.show', $lead) }}"
                                            class="btn-action btn-action-view btn-action-icon" title="View Lead Dossier">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    @endcan

                                    @can('edit-leads')
                                        <a href="{{ route('admin.leads.edit', $lead) }}"
                                            class="btn-action btn-action-edit btn-action-icon" title="Edit Lead">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                    @endcan

                                    @can('delete-leads')
                                        <form action="{{ route('admin.leads.destroy', $lead) }}" method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Are you sure you want to delete lead \'{{ $lead->name }}\'?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-action btn-action-delete btn-action-icon"
                                                title="Delete Lead">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                        </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-5">
                                <div class="py-3">
                                    <i class="bi bi-inbox text-secondary" style="font-size: 2.5rem;"></i>
                                    <h5 class="mt-2 text-dark">No Leads Found</h5>
                                    <p class="text-muted small">No inquiries or sales leads match your filter parameters.
                                    </p>
                                    @can('create-leads')
                                        <a href="{{ route('admin.leads.create') }}" class="btn primary btn-sm mt-2">
                                            <i class="bi bi-plus-lg me-1"></i> Add New Lead
                                        </a>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($leads->hasPages())
            <div class="p-3 border-top d-flex justify-content-end">
                {{ $leads->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
@endsection
