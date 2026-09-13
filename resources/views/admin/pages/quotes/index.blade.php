@extends('admin.layouts.admin-master')

@section('title', 'Quotes & Proposals')

@section('content')
    {{-- Page Header --}}
    <div class="heading">
        <div>
            <small>AGENCY ADMIN</small>
            <h1>Quotes & Proposals</h1>
            <p>Track client quotations, proposal delivery, pricing estimates, and deal approvals.</p>
        </div>
        <div>
            @can('create-quotes')
                <a href="{{ route('admin.quotes.create') }}" class="btn primary">
                    <i class="bi bi-plus-lg me-1"></i> Add Quote
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
                <i class="bi bi-file-earmark-text"></i>
            </div>
            <div class="lead-stat-content">
                <h4>{{ number_format($totalCount ?? 0) }}</h4>
                <span>Total Quotes</span>
            </div>
        </div>

        <div class="lead-stat-card">
            <div class="lead-stat-icon icon-info">
                <i class="bi bi-file-earmark"></i>
            </div>
            <div class="lead-stat-content">
                <h4>{{ number_format($draftCount ?? 0) }}</h4>
                <span>Draft Quotes</span>
            </div>
        </div>

        <div class="lead-stat-card">
            <div class="lead-stat-icon icon-warning">
                <i class="bi bi-send"></i>
            </div>
            <div class="lead-stat-content">
                <h4>{{ number_format($sentCount ?? 0) }}</h4>
                <span>Sent Proposals</span>
            </div>
        </div>

        <div class="lead-stat-card">
            <div class="lead-stat-icon icon-success">
                <i class="bi bi-check-circle-fill"></i>
            </div>
            <div class="lead-stat-content">
                <h4>{{ number_format($acceptedCount ?? 0) }}</h4>
                <span>Accepted / Won</span>
            </div>
        </div>

        <div class="lead-stat-card">
            <div class="lead-stat-icon icon-value">
                <i class="bi bi-currency-dollar"></i>
            </div>
            <div class="lead-stat-content">
                <h4>{{ $defaultCurrency?->symbol ?? '$' }}{{ number_format($totalPipelineValue ?? 0.0, 0) }}</h4>
                <span>Pipeline Value</span>
            </div>
        </div>
    </div>

    {{-- Quotes Table Card --}}
    <div class="card list-card">
        {{-- Search & Filters --}}
        <div class="toolbar">
            <form method="GET" action="{{ route('admin.quotes') }}" class="toolbar-filters flex-wrap">
                <input type="text" name="search" value="{{ $currentSearch ?? '' }}"
                    placeholder="Search quote #, title, client..." class="filter-search-input">

                <select name="status" onchange="this.form.submit()" class="filter-select">
                    <option value="">All Statuses</option>
                    @foreach ($statuses ?? [] as $statusOption)
                        <option value="{{ $statusOption->value }}"
                            {{ ($currentStatus ?? '') === $statusOption->value ? 'selected' : '' }}>
                            {{ $statusOption->label() }}
                        </option>
                    @endforeach
                </select>

                <select name="lead_id" onchange="this.form.submit()" class="filter-select">
                    <option value="">All Leads / Clients</option>
                    @foreach ($leads ?? [] as $leadOption)
                        <option value="{{ $leadOption->id }}"
                            {{ (string) ($currentLead ?? '') === (string) $leadOption->id ? 'selected' : '' }}>
                            {{ $leadOption->company_name ?: $leadOption->name }}
                        </option>
                    @endforeach
                </select>

                <button type="submit" class="btn light">Filter</button>

                @if (!empty($currentSearch) || !empty($currentStatus) || !empty($currentLead))
                    <a href="{{ route('admin.quotes') }}" class="btn light filter-btn-reset">
                        Reset
                    </a>
                @endif
            </form>
        </div>

        <div class="tablewrap">
            <table>
                <thead>
                    <tr>
                        <th class="col-quote-info">QUOTE / TITLE</th>
                        <th>CLIENT / LEAD</th>
                        <th>SERVICES</th>
                        <th>EST. BUDGET</th>
                        <th>STATUS</th>
                        <th>VALID UNTIL</th>
                        <th class="text-end-align">ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($quotes ?? [] as $quote)
                        @php
                            $quoteInitial = 'Q';
                            if ($quote->lead?->name) {
                                $quoteInitial = collect(explode(' ', $quote->lead->name))
                                    ->map(fn($w) => mb_substr($w, 0, 1))
                                    ->take(2)
                                    ->join('');
                            }
                        @endphp
                        <tr>
                            <td>
                                <div class="lead-cell-contact">
                                    <div class="lead-avatar-circle">
                                        {{ strtoupper($quoteInitial ?: 'Q') }}
                                    </div>
                                    <div class="lead-name-box">
                                        <a href="{{ route('admin.quotes.show', $quote) }}" class="text-decoration-none">
                                            <strong>{{ $quote->title }}</strong>
                                        </a>
                                        <span class="lead-company">
                                            <i class="bi bi-hash"></i>{{ $quote->quote_number }}
                                        </span>
                                        <div class="lead-contact-meta">
                                            <span class="lead-contact-item text-muted" title="Prepared by {{ $quote->creator?->name ?? 'System' }}">
                                                <i class="bi bi-person"></i>
                                                <span class="lead-contact-text">{{ $quote->creator?->name ?? 'System' }}</span>
                                            </span>
                                            <span class="lead-contact-item text-muted" title="Created at {{ $quote->created_at->format('M d, Y') }}">
                                                <i class="bi bi-calendar3"></i>
                                                <span class="lead-contact-text">{{ $quote->created_at->format('M d, Y') }}</span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if ($quote->lead)
                                    <div class="lead-name-box">
                                        <a href="{{ route('admin.leads.show', $quote->lead) }}" class="text-decoration-none fw-semibold text-dark">
                                            {{ $quote->lead->company_name ?: $quote->lead->name }}
                                        </a>
                                        @if ($quote->lead->company_name && $quote->lead->name)
                                            <span class="text-muted small d-block">
                                                <i class="bi bi-person me-1"></i>{{ $quote->lead->name }}
                                            </span>
                                        @endif
                                        @if ($quote->lead->email)
                                            <div class="lead-contact-meta">
                                                <a href="mailto:{{ $quote->lead->email }}" class="lead-contact-item" title="{{ $quote->lead->email }}">
                                                    <i class="bi bi-envelope"></i>
                                                    <span class="lead-contact-text">{{ $quote->lead->email }}</span>
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                @else
                                    <span class="text-muted small">—</span>
                                @endif
                            </td>
                            <td>
                                <div class="lead-services-wrap">
                                    @php
                                        $renderedServices = 0;
                                    @endphp
                                    @if ($quote->services->isNotEmpty())
                                        @foreach ($quote->services as $quoteService)
                                            @if ($quoteService->service)
                                                <span class="lead-service-tag">{{ $quoteService->service->name }}</span>
                                                @php $renderedServices++; @endphp
                                            @endif
                                        @endforeach
                                    @elseif ($quote->lead && $quote->lead->services->isNotEmpty())
                                        @foreach ($quote->lead->services as $leadService)
                                            <span class="lead-service-tag">{{ $leadService->name }}</span>
                                            @php $renderedServices++; @endphp
                                        @endforeach
                                    @endif

                                    @if ($renderedServices === 0)
                                        <span class="text-muted small">General Inquiry</span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                @php
                                    $itemSym = $quote->currency?->symbol ?? $defaultCurrency?->symbol ?? '$';
                                    $itemCode = $quote->currency?->code ?? $defaultCurrency?->code ?? 'USD';
                                @endphp
                                @if ($quote->budget_min && $quote->budget_max)
                                    <span class="lead-budget-text">{{ $itemSym }}{{ number_format($quote->budget_min, 0) }} – {{ $itemSym }}{{ number_format($quote->budget_max, 0) }}</span>
                                    <span class="lead-budget-currency">{{ $itemCode }}</span>
                                @elseif ($quote->budget_max)
                                    <span class="lead-budget-text">{{ $itemSym }}{{ number_format($quote->budget_max, 0) }}</span>
                                    <span class="lead-budget-currency">{{ $itemCode }}</span>
                                @elseif ($quote->budget_min)
                                    <span class="lead-budget-text">{{ $itemSym }}{{ number_format($quote->budget_min, 0) }}</span>
                                    <span class="lead-budget-currency">{{ $itemCode }}</span>
                                @else
                                    <span class="text-muted small">—</span>
                                @endif
                            </td>
                            <td>
                                <span class="status-badge {{ $quote->status->badgeClass() }}">
                                    <i class="bi {{ $quote->status->icon() }} me-1"></i>
                                    {{ $quote->status->label() }}
                                </span>
                            </td>
                            <td>
                                @if ($quote->valid_until)
                                    <span class="fw-semibold text-dark small d-block">
                                        {{ $quote->valid_until->format('M d, Y') }}
                                    </span>
                                    @if ($quote->valid_until->isPast())
                                        <small class="badge bg-danger-subtle text-danger border border-danger-subtle">Expired</small>
                                    @else
                                        <small class="text-muted">{{ $quote->valid_until->diffForHumans() }}</small>
                                    @endif
                                @else
                                    <span class="text-muted small">No Expiry</span>
                                @endif
                            </td>
                            <td class="text-end-align nowrap-cell">
                                <div class="table-actions">
                                    @can('view-quotes')
                                        <a href="{{ route('admin.quotes.show', $quote) }}"
                                            class="btn-action btn-action-view btn-action-icon" title="View Quote Details">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    @endcan

                                    @can('edit-quotes')
                                        <a href="{{ route('admin.quotes.edit', $quote) }}"
                                            class="btn-action btn-action-edit btn-action-icon" title="Edit Quote">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                    @endcan

                                    @can('delete-quotes')
                                        <form action="{{ route('admin.quotes.destroy', $quote) }}" method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Are you sure you want to delete quote \'{{ $quote->quote_number }}\'?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-action btn-action-delete btn-action-icon"
                                                title="Delete Quote">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                        </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-5">
                                <div class="py-3">
                                    <i class="bi bi-inbox text-secondary" style="font-size: 2.5rem;"></i>
                                    <h5 class="mt-2 text-dark">No Quotes Found</h5>
                                    <p class="text-muted small">No proposals or quotations match your filter parameters.</p>
                                    @can('create-quotes')
                                        <a href="{{ route('admin.quotes.create') }}" class="btn primary btn-sm mt-2">
                                            <i class="bi bi-plus-lg me-1"></i> Add New Quote
                                        </a>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($quotes->hasPages())
            <div class="p-3 border-top d-flex justify-content-end">
                {{ $quotes->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
@endsection
