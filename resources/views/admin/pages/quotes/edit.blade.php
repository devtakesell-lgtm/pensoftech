@extends('admin.layouts.admin-master')

@section('title', 'Edit Quote - ' . $quote->quote_number)

@section('content')
    <div class="mb-3">
        <a href="{{ route('admin.quotes.show', $quote) }}" class="btn light btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Back to Quote
        </a>
    </div>

    <div class="dossier-card">
        <h3 class="dossier-card-title">
            <i class="bi bi-pencil-square text-primary"></i> Edit Quote {{ $quote->quote_number }}
        </h3>

        <form action="{{ route('admin.quotes.update', $quote) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="lead_id" class="form-label fw-semibold">Lead <span class="text-danger">*</span></label>
                    <select class="form-select" id="lead_id" name="lead_id" required>
                        <option value="">Select Lead...</option>
                        @foreach($leads as $leadOption)
                            <option value="{{ $leadOption->id }}" {{ (old('lead_id', $quote->lead_id) == $leadOption->id) ? 'selected' : '' }}>
                                {{ $leadOption->name }} ({{ $leadOption->company_name }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="currency_id" class="form-label fw-semibold">Currency <span class="text-danger">*</span></label>
                    <select class="form-select" id="currency_id" name="currency_id" required>
                        <option value="">Select Currency...</option>
                        @foreach($currencies as $currencyOption)
                            <option value="{{ $currencyOption->id }}" {{ (old('currency_id', $quote->currency_id) == $currencyOption->id) ? 'selected' : '' }}>
                                {{ $currencyOption->name }} ({{ $currencyOption->symbol }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-12">
                    <label for="title" class="form-label fw-semibold">Quote Title <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $quote->title) }}" required>
                </div>

                <div class="col-md-12">
                    <label for="description" class="form-label fw-semibold">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="4">{{ old('description', $quote->description) }}</textarea>
                </div>

                <div class="col-md-6">
                    <label for="budget_min" class="form-label fw-semibold">Minimum Budget</label>
                    <input type="number" step="0.01" class="form-control" id="budget_min" name="budget_min" value="{{ old('budget_min', $quote->budget_min) }}">
                </div>

                <div class="col-md-6">
                    <label for="budget_max" class="form-label fw-semibold">Maximum Budget</label>
                    <input type="number" step="0.01" class="form-control" id="budget_max" name="budget_max" value="{{ old('budget_max', $quote->budget_max) }}">
                </div>

                <div class="col-md-6">
                    <label for="status" class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                    <select class="form-select" id="status" name="status" required>
                        @foreach($statuses as $statusOption)
                            <option value="{{ $statusOption->value }}" {{ old('status', $quote->status->value) == $statusOption->value ? 'selected' : '' }}>
                                {{ $statusOption->label() }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="valid_until" class="form-label fw-semibold">Valid Until</label>
                    <input type="date" class="form-control" id="valid_until" name="valid_until" value="{{ old('valid_until', $quote->valid_until ? $quote->valid_until->format('Y-m-d') : '') }}">
                </div>
            </div>

            <div class="mt-4 text-end">
                <a href="{{ route('admin.quotes.show', $quote) }}" class="btn btn-light">Cancel</a>
                <button type="submit" class="btn primary">
                    <i class="bi bi-check-lg me-1"></i> Update Quote
                </button>
            </div>
        </form>
    </div>
@endsection
