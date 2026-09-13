@extends('admin.layouts.admin-master')

@section('title', 'Quote Details - ' . $quote->quote_number)

@section('content')
    <div class="mb-3">
        <a href="{{ route('admin.quotes') }}" class="btn light btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Back to Quotes
        </a>
    </div>

    @if (session('success'))
        <div class="alert-custom alert-custom-success">
            <i class="bi bi-check-circle-fill"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="dossier-hero">
        <div class="dossier-hero-title">
            <div class="dossier-avatar-large bg-primary text-white">
                <i class="bi bi-file-earmark-text"></i>
            </div>
            <div class="dossier-hero-info">
                <h2>{{ $quote->title }}</h2>
                <p>
                    <strong>{{ $quote->quote_number }}</strong> &bull;
                    <span>Created on {{ $quote->created_at->format('M d, Y') }}</span>
                    @if ($quote->lead)
                        &bull; <span class="badge bg-light text-dark border">Lead: {{ $quote->lead->name }}
                            @if ($quote->lead->isConvertedClient())
                                <x-verified-badge title="Converted Client Account" :url="route('admin.clients')" />
                            @endif
                        </span>
                    @endif
                </p>
            </div>
        </div>

        <div class="dossier-hero-actions">
            <span class="status-badge {{ $quote->status->badgeClass() }} fs-6 py-2 px-3">
                <i class="bi {{ $quote->status->icon() }} me-1"></i>
                {{ $quote->status->label() }}
            </span>

            {{-- Smart Lifecycle Actions --}}
            @can('edit-quotes')
                @if ($quote->status === \App\Enums\QuoteStatus::Draft)
                    <form action="{{ route('admin.quotes.update-status', $quote) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="{{ \App\Enums\QuoteStatus::Sent->value }}">
                        <button type="submit" class="btn primary">
                            <i class="bi bi-send me-1"></i> Send to Client
                        </button>
                    </form>
                @elseif ($quote->status === \App\Enums\QuoteStatus::Sent)
                    <form action="{{ route('admin.quotes.update-status', $quote) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="{{ \App\Enums\QuoteStatus::Accepted->value }}">
                        <button type="submit" class="btn light text-success fw-bold" title="Mark quote as accepted by client">
                            <i class="bi bi-check-circle-fill me-1"></i> Mark as Accepted
                        </button>
                    </form>

                    <form action="{{ route('admin.quotes.update-status', $quote) }}" method="POST" class="d-inline"
                        onsubmit="return confirm('Are you sure you want to mark this quote as rejected?');">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="{{ \App\Enums\QuoteStatus::Rejected->value }}">
                        <button type="submit" class="btn light text-danger" title="Mark quote as rejected">
                            <i class="bi bi-x-circle me-1"></i> Reject
                        </button>
                    </form>
                @elseif ($quote->status === \App\Enums\QuoteStatus::Accepted)
                    <span class="btn light disabled text-success fw-bold">
                        <i class="bi bi-trophy-fill me-1"></i> Won Deal
                    </span>
                @endif

                @if ($quote->status !== \App\Enums\QuoteStatus::Accepted)
                    <a href="{{ route('admin.quotes.edit', $quote) }}" class="btn light">
                        <i class="bi bi-pencil-square me-1"></i> Edit
                    </a>
                @endif
            @endcan

            @can('delete-quotes')
                <form action="{{ route('admin.quotes.destroy', $quote) }}" method="POST" class="d-inline"
                    onsubmit="return confirm('Are you sure you want to delete this quote?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn light text-danger" title="Delete Quote">
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
                    <i class="bi bi-info-circle-fill text-primary"></i> Quote Description
                </h3>
                @if ($quote->description)
                    <div class="dossier-message-box">
                        {!! nl2br(e($quote->description)) !!}
                    </div>
                @else
                    <p class="text-muted fst-italic">No description provided.</p>
                @endif
            </div>
        </div>

        <div>
            <div class="dossier-card">
                <h3 class="dossier-card-title">
                    <i class="bi bi-cash-stack text-primary"></i> Financials
                </h3>
                <div class="dossier-data-row">
                    <span class="dossier-label">Estimated Budget</span>
                    <span class="dossier-value text-success fs-5">
                        @php
                            $sym = $quote->currency?->symbol ?? '$';
                        @endphp
                        @if ($quote->budget_min && $quote->budget_max)
                            {{ $sym }}{{ number_format($quote->budget_min, 2) }} –
                            {{ $sym }}{{ number_format($quote->budget_max, 2) }}
                        @elseif ($quote->budget_max)
                            {{ $sym }}{{ number_format($quote->budget_max, 2) }}
                        @elseif ($quote->budget_min)
                            {{ $sym }}{{ number_format($quote->budget_min, 2) }}
                        @else
                            <span class="text-muted fs-6">Unspecified</span>
                        @endif
                    </span>
                </div>
                <div class="dossier-data-row">
                    <span class="dossier-label">Valid Until</span>
                    <span class="dossier-value">
                        @if ($quote->valid_until)
                            {{ $quote->valid_until->format('M d, Y') }}
                            @if ($quote->valid_until->isPast())
                                <span class="badge bg-danger">Expired</span>
                            @endif
                        @else
                            <span class="text-muted">No expiry date</span>
                        @endif
                    </span>
                </div>
            </div>

            <div class="dossier-card">
                <h3 class="dossier-card-title">
                    <i class="bi bi-person-badge-fill text-primary"></i> Details
                </h3>
                <div class="dossier-data-row">
                    <span class="dossier-label">Prepared By</span>
                    <span class="dossier-value">
                        {{ $quote->creator?->name ?? 'System' }}
                    </span>
                </div>
                @if ($quote->lead)
                    <div class="dossier-data-row">
                        <span class="dossier-label">Lead</span>
                        <span class="dossier-value">
                            <a href="{{ route('admin.leads.show', $quote->lead) }}">
                                {{ $quote->lead->name }} ({{ $quote->lead->company_name }})
                            </a>
                        </span>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
