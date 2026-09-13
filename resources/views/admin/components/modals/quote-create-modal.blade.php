@props([
    'lead',
    'currencies',
    'quoteStatuses',
    'defaultCurrency',
    'modalId' => 'createQuoteModal'
])

<div class="modal fade" id="{{ $modalId }}" tabindex="-1" aria-labelledby="{{ $modalId }}Label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fs-4 fw-bold text-dark" id="{{ $modalId }}Label">
                    <i class="bi bi-file-earmark-plus text-primary me-2"></i> Create Quote / Proposal
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="{{ route('admin.quotes.store') }}" method="POST">
                @csrf
                <input type="hidden" name="redirect_to" value="lead">
                <input type="hidden" name="lead_id" value="{{ $lead->id }}">
                
                <div class="modal-body py-4">
                    <p class="text-muted mb-4">
                        Creating a new quote for <strong>{{ $lead->name }}</strong> ({{ $lead->company_name ?? 'No Company' }}).
                    </p>

                    <div class="row g-3">
                        <div class="col-md-12">
                            <label for="title" class="form-label fw-semibold">Quote Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="title" name="title" value="{{ old('title', 'Proposal for ' . ($lead->company_name ?? $lead->name)) }}" required>
                        </div>

                        <div class="col-md-6">
                            <label for="currency_id" class="form-label fw-semibold">Currency <span class="text-danger">*</span></label>
                            <select class="form-select" id="currency_id" name="currency_id" required>
                                @foreach($currencies as $currencyOption)
                                    <option value="{{ $currencyOption->id }}" {{ (old('currency_id', $lead->currency_id ?? $defaultCurrency?->id) == $currencyOption->id) ? 'selected' : '' }}>
                                        {{ $currencyOption->name }} ({{ $currencyOption->symbol }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="col-md-6">
                            <label for="status" class="form-label fw-semibold">Initial Status <span class="text-danger">*</span></label>
                            <select class="form-select" id="status" name="status" required>
                                @foreach($quoteStatuses as $statusOption)
                                    <option value="{{ $statusOption->value }}" {{ old('status') == $statusOption->value ? 'selected' : '' }}>
                                        {{ $statusOption->label() }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="budget_min" class="form-label fw-semibold">Minimum Budget</label>
                            <input type="number" step="0.01" class="form-control" id="budget_min" name="budget_min" value="{{ old('budget_min', $lead->budget) }}">
                        </div>

                        <div class="col-md-6">
                            <label for="budget_max" class="form-label fw-semibold">Maximum Budget</label>
                            <input type="number" step="0.01" class="form-control" id="budget_max" name="budget_max" value="{{ old('budget_max', $lead->budget) }}">
                        </div>

                        <div class="col-md-12">
                            <label for="valid_until" class="form-label fw-semibold">Valid Until</label>
                            <input type="date" class="form-control" id="valid_until" name="valid_until" value="{{ old('valid_until', now()->addDays(30)->format('Y-m-d')) }}">
                        </div>
                        
                        <div class="col-md-12">
                            <label for="description" class="form-label fw-semibold">Description / Notes</label>
                            <textarea class="form-control" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer border-top-0 pt-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn primary">
                        <i class="bi bi-check-lg me-1"></i> Create Quote
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
