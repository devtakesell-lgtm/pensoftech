@extends('admin.layouts.admin-master')

@section('title', 'Create Sales Lead')

@section('content')
<div class="heading">
    <div>
        <small>LEAD MANAGEMENT</small>
        <h1>Add New Lead</h1>
        <p>Register a new client inquiry, configure estimated budget, assign team ownership, and set initial pipeline status.</p>
    </div>
    <div>
        <a href="{{ route('admin.leads') }}" class="btn light">
            <i class="bi bi-arrow-left me-1"></i> Back to Leads
        </a>
    </div>
</div>

{{-- Validation Errors --}}
@if($errors->any())
    <div class="alert-custom alert-custom-danger">
        <div>
            <strong>Please resolve the following issues:</strong>
            <ul class="mb-0 mt-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif

<form action="{{ route('admin.leads.store') }}" method="POST">
    @csrf

    {{-- Card 1: Contact & Organization --}}
    <div class="card form-card mb-4">
        <h3 class="form-card-title">
            <i class="bi bi-person-lines-fill me-2 text-primary"></i> Contact & Company Details
        </h3>

        <div class="form-grid-3">
            <div class="form-group">
                <label class="form-label">Contact Name *</label>
                <input type="text" name="name" value="{{ old('name') }}" placeholder="e.g. Alex Henderson" required class="form-input">
            </div>

            <div class="form-group">
                <label class="form-label">Company / Organization</label>
                <input type="text" name="company_name" value="{{ old('company_name') }}" placeholder="e.g. Acme Innovations Corp" class="form-input">
            </div>

            <div class="form-group">
                <label class="form-label">Email Address</label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="e.g. alex@acme.io" class="form-input">
            </div>
        </div>

        <div class="form-grid-2 mt-3">
            <div class="form-group">
                <label class="form-label">Phone Number</label>
                <input type="text" name="phone" value="{{ old('phone') }}" placeholder="e.g. +1 (555) 234-5678" class="form-input">
            </div>

            <div class="form-group">
                <label class="form-label">Website URL</label>
                <input type="text" name="website" value="{{ old('website') }}" placeholder="e.g. https://acme.io" class="form-input">
            </div>
        </div>
    </div>

    {{-- Card 2: Commercial Opportunity & Interested Services --}}
    <div class="card form-card mb-4">
        <h3 class="form-card-title">
            <i class="bi bi-briefcase-fill me-2 text-primary"></i> Opportunity & Interested Services
        </h3>

        <div class="form-group mb-3">
            <label class="form-label d-block">Interested Agency Services</label>
            <div class="row g-2">
                @foreach($services ?? [] as $service)
                    <div class="col-md-4 col-sm-6">
                        <label class="d-flex align-items-center gap-2 p-2 border rounded bg-light cursor-pointer">
                            <input type="checkbox" name="service_ids[]" value="{{ $service->id }}"
                                {{ in_array($service->id, old('service_ids', [])) ? 'checked' : '' }}
                                class="form-check-input mt-0">
                            <span class="small fw-semibold text-dark">{{ $service->name }}</span>
                        </label>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="form-grid-3">
            <div class="form-group">
                <label class="form-label">Estimated Budget</label>
                <input type="number" step="0.01" name="budget" value="{{ old('budget') }}" placeholder="e.g. 10000" class="form-input">
            </div>

            <div class="form-group">
                <label class="form-label">Currency</label>
                <select name="currency_id" class="form-input">
                    <option value="">Select Currency</option>
                    @foreach($currencies ?? [] as $currency)
                        <option value="{{ $currency->id }}" {{ (string) old('currency_id') === (string) $currency->id || ($currency->is_default && !old('currency_id')) ? 'selected' : '' }}>
                            {{ $currency->name }} ({{ $currency->code }} - {{ $currency->symbol }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Industry Vertical</label>
                <select name="industry_id" class="form-input">
                    <option value="">Select Industry</option>
                    @foreach($industries ?? [] as $industry)
                        <option value="{{ $industry->id }}" {{ (string) old('industry_id') === (string) $industry->id ? 'selected' : '' }}>
                            {{ $industry->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-grid-2 mt-3">
            <div class="form-group">
                <label class="form-label">Lead Project Type</label>
                <select name="lead_type" class="form-input">
                    <option value="">Select Project Type</option>
                    @foreach($types ?? [] as $typeKey => $typeLabel)
                        <option value="{{ $typeKey }}" {{ old('lead_type') === $typeKey ? 'selected' : '' }}>
                            {{ $typeLabel }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Lead Source</label>
                <select name="lead_source" class="form-input">
                    <option value="">Select Acquisition Source</option>
                    @foreach($sources ?? [] as $sourceKey => $sourceLabel)
                        <option value="{{ $sourceKey }}" {{ old('lead_source') === $sourceKey ? 'selected' : '' }}>
                            {{ $sourceLabel }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    {{-- Card 3: Pipeline Ownership & Initial Status --}}
    <div class="card form-card mb-4">
        <h3 class="form-card-title">
            <i class="bi bi-diagram-3-fill me-2 text-primary"></i> Ownership & Pipeline Stage
        </h3>

        <div class="form-grid-2">
            <div class="form-group">
                <label class="form-label">Assign to Staff Member</label>
                <select name="assigned_to" class="form-input">
                    <option value="">Unassigned</option>
                    @foreach($assignees ?? [] as $assignee)
                        <option value="{{ $assignee->id }}" {{ (string) old('assigned_to') === (string) $assignee->id ? 'selected' : '' }}>
                            {{ $assignee->name }} ({{ $assignee->email }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Initial Status *</label>
                <select name="status" required class="form-input">
                    @foreach($statuses ?? [] as $statusOption)
                        <option value="{{ $statusOption->value }}" {{ old('status', 'new') === $statusOption->value ? 'selected' : '' }}>
                            {{ $statusOption->label() }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    {{-- Card 4: Project Scope & Brief --}}
    <div class="card form-card mb-4">
        <h3 class="form-card-title">
            <i class="bi bi-chat-left-text-fill me-2 text-primary"></i> Project Brief & Requirements
        </h3>

        <div class="form-group">
            <label class="form-label">Client Message / Project Description</label>
            <textarea name="message" rows="5" placeholder="Details about project objectives, timeline, special requirements, or kickoff notes..." class="form-textarea form-textarea-lg">{{ old('message') }}</textarea>
        </div>
    </div>

    {{-- Card 5: Optional Marketing Attribution --}}
    <div class="card form-card mb-4">
        <h3 class="form-card-title">
            <i class="bi bi-megaphone-fill me-2 text-primary"></i> Marketing Campaign Attribution (Optional)
        </h3>

        <div class="form-grid-4">
            <div class="form-group">
                <label class="form-label">UTM Source</label>
                <input type="text" name="utm_source" value="{{ old('utm_source') }}" placeholder="e.g. google, linkedin" class="form-input">
            </div>

            <div class="form-group">
                <label class="form-label">UTM Medium</label>
                <input type="text" name="utm_medium" value="{{ old('utm_medium') }}" placeholder="e.g. cpc, referral" class="form-input">
            </div>

            <div class="form-group">
                <label class="form-label">UTM Campaign</label>
                <input type="text" name="utm_campaign" value="{{ old('utm_campaign') }}" placeholder="e.g. q3_enterprise_launch" class="form-input">
            </div>

            <div class="form-group">
                <label class="form-label">UTM Content</label>
                <input type="text" name="utm_content" value="{{ old('utm_content') }}" placeholder="e.g. hero_cta_button" class="form-input">
            </div>
        </div>
    </div>

    {{-- Form Submit Actions --}}
    <div class="d-flex justify-content-end gap-2 mb-5">
        <a href="{{ route('admin.leads') }}" class="btn light">
            Cancel
        </a>
        <button type="submit" class="btn primary">
            <i class="bi bi-check-lg me-1"></i> Save & Create Lead
        </button>
    </div>
</form>
@endsection
