@extends('admin.layouts.admin-master')

@section('title', 'Edit Client - ' . $client->company_name)

@section('content')
    <div class="heading d-flex justify-content-between align-items-center mb-4">
        <div>
            <a href="{{ route('admin.clients') }}" class="text-decoration-none text-muted mb-2 d-inline-block">
                <i class="bi bi-arrow-left me-1"></i> Back to Clients
            </a>
            <h1>Edit Client</h1>
            <p>Update client profile and contact information for {{ $client->company_name }}.</p>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert-custom alert-custom-danger mb-4">
            <i class="bi bi-exclamation-triangle-fill"></i>
            <div>
                <strong>Please fix the following errors:</strong>
                <ul class="mb-0 mt-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <div class="card p-4">
        <form action="{{ route('admin.clients.update', $client) }}" method="POST">
            @csrf
            @method('PUT')

            <h5 class="fw-bold mb-4 border-bottom pb-2">Client Information</h5>
            
            <div class="row g-4 mb-4">
                <div class="col-md-6">
                    <label for="company_name" class="form-label fw-semibold">Company Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="company_name" name="company_name" value="{{ old('company_name', $client->company_name) }}" required>
                </div>
                
                <div class="col-md-6">
                    <label for="contact_person" class="form-label fw-semibold">Primary Contact Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="contact_person" name="contact_person" value="{{ old('contact_person', $client->contact_person) }}" required>
                </div>

                <div class="col-md-6">
                    <label for="email" class="form-label fw-semibold">Email Address (Login ID) <span class="text-danger">*</span></label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $client->user?->email) }}" required>
                </div>

                <div class="col-md-6">
                    <label for="phone" class="form-label fw-semibold">Phone Number</label>
                    <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', $client->phone) }}">
                </div>

                <div class="col-md-12">
                    <label for="website" class="form-label fw-semibold">Website</label>
                    <input type="text" class="form-control" id="website" name="website" value="{{ old('website', $client->website) }}" placeholder="e.g. example.com or https://example.com">
                </div>
            </div>

            <h5 class="fw-bold mb-4 border-bottom pb-2">Location</h5>
            
            <div class="row g-4 mb-4">
                <div class="col-md-12">
                    <label for="address" class="form-label fw-semibold">Street Address</label>
                    <input type="text" class="form-control" id="address" name="address" value="{{ old('address', $client->address) }}">
                </div>
                
                <div class="col-md-6">
                    <label for="city" class="form-label fw-semibold">City</label>
                    <input type="text" class="form-control" id="city" name="city" value="{{ old('city', $client->city) }}">
                </div>

                <div class="col-md-6">
                    <label for="country" class="form-label fw-semibold">Country</label>
                    <input type="text" class="form-control" id="country" name="country" value="{{ old('country', $client->country) }}">
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-4 pt-4 border-top">
                <a href="{{ route('admin.clients') }}" class="btn btn-light">Cancel</a>
                <button type="submit" class="btn primary">
                    <i class="bi bi-save me-1"></i> Save Changes
                </button>
            </div>
        </form>
    </div>
@endsection
