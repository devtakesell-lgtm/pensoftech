@extends('client.layouts.client-master')

@section('title', 'Request New Service')
@section('page_title', 'Request New Service')
@section('breadcrumb_current', 'New Request')

@section('content')
    <div style="max-width: 840px; margin: 0 auto;">
        <!-- Header -->
        <div style="margin-bottom: 24px;">
            <a href="{{ route('client.leads.index') }}" class="btn-secondary" style="margin-bottom: 14px;">
                <i class="bi bi-arrow-left"></i>
                <span>Back to Inquiries</span>
            </a>
            <h2 style="font-size: 1.4rem; font-weight: 800; color: var(--cp-dark); letter-spacing: -0.02em;">
                Submit a Project or Service Request
            </h2>
            <p style="font-size: 0.88rem; color: var(--cp-ink-muted); margin-top: 4px;">
                Tell us about your upcoming project requirements, needed tech stack, or feature enhancements. Our team will prepare a structured proposal.
            </p>
        </div>

        <!-- Form Card -->
        <div class="form-card">
            <form method="POST" action="{{ route('client.leads.store') }}">
                @csrf

                <!-- Subject / Title -->
                <div class="form-group">
                    <label for="project_title" class="form-label">
                        Project / Service Title <span class="req">*</span>
                    </label>
                    <input type="text" 
                           id="project_title" 
                           name="project_title" 
                           value="{{ old('project_title') }}" 
                           placeholder="e.g., E-commerce Platform Redesign or Custom CRM Integration" 
                           class="form-control @error('project_title') is-invalid @enderror" 
                           required>
                    @error('project_title')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Services Checkboxes -->
                @if ($services->isNotEmpty())
                    <div class="form-group">
                        <label class="form-label">Select Relevant Services (Optional)</label>
                        <div class="checkbox-grid">
                            @foreach ($services as $service)
                                <label class="checkbox-card">
                                    <input type="checkbox" 
                                           name="service_ids[]" 
                                           value="{{ $service->id }}" 
                                           {{ in_array($service->id, old('service_ids', [])) ? 'checked' : '' }}>
                                    <span class="checkbox-card-label">{{ $service->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Estimated Budget -->
                <div class="form-group">
                    <label for="budget" class="form-label">Estimated Budget (USD, Optional)</label>
                    <input type="number" 
                           id="budget" 
                           name="budget" 
                           step="0.01" 
                           value="{{ old('budget') }}" 
                           placeholder="e.g. 5000" 
                           class="form-control @error('budget') is-invalid @enderror">
                    <span class="form-helper">Providing an estimate helps us propose the best technology architecture for your goals.</span>
                    @error('budget')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Requirements / Message -->
                <div class="form-group">
                    <label for="message" class="form-label">
                        Project Details & Requirements <span class="req">*</span>
                    </label>
                    <textarea id="message" 
                              name="message" 
                              rows="6" 
                              class="form-textarea @error('message') is-invalid @enderror" 
                              placeholder="Please describe your project scope, target launch timeline, key features, or any specific challenges you want us to solve..." 
                              required>{{ old('message') }}</textarea>
                    @error('message')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Form Actions -->
                <div class="form-actions">
                    <a href="{{ route('client.leads.index') }}" class="btn-secondary">
                        Cancel
                    </a>
                    <button type="submit" class="btn-primary">
                        <i class="bi bi-send-fill"></i>
                        <span>Submit Request</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
