@extends('admin.layouts.admin-master')

@section('title', 'Edit Industry - ' . $industry->name)

@section('content')
    <div class="heading d-flex justify-content-between align-items-center mb-4">
        <div>
            <a href="{{ route('admin.industries') }}" class="text-decoration-none text-muted mb-2 d-inline-block">
                <i class="bi bi-arrow-left me-1"></i> Back to Industries
            </a>
            <h1>Edit Industry</h1>
            <p>Update category details for {{ $industry->name }}.</p>
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
        <form action="{{ route('admin.industries.update', $industry) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <h5 class="fw-bold mb-4 border-bottom pb-2">Industry Details</h5>

            <div class="row g-4 mb-4">
                <div class="col-md-6">
                    <label for="name" class="form-label fw-semibold">Industry Name <span
                            class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="name" name="name"
                        value="{{ old('name', $industry->name) }}" required>
                </div>

                <div class="col-md-6">
                    <label for="icon" class="form-label fw-semibold">Bootstrap Icon Class</label>
                    <input type="text" class="form-control" id="icon" name="icon"
                        value="{{ old('icon', $industry->icon) }}" placeholder="e.g. bi-tags">
                </div>



                <div class="col-md-12">
                    <label for="short_description" class="form-label fw-semibold">Short Description</label>
                    <textarea class="form-control" id="short_description" name="short_description" rows="2">{{ old('short_description', $industry->short_description) }}</textarea>
                </div>

                <div class="col-md-12">
                    <label for="description" class="form-label fw-semibold">Detailed Description</label>
                    <textarea class="form-control" id="description" name="description" rows="4">{{ old('description', $industry->description) }}</textarea>
                </div>
            </div>

            <h5 class="fw-bold mb-4 border-bottom pb-2">Settings</h5>

            <div class="row g-4 mb-4">
                <div class="col-md-6">
                    <label for="sort_order" class="form-label fw-semibold">Sort Order</label>
                    <input type="number" class="form-control" id="sort_order" name="sort_order"
                        value="{{ old('sort_order', $industry->sort_order) }}" min="0">
                    <small class="text-muted">Lower numbers appear first.</small>
                </div>

                <div class="col-md-6 d-flex align-items-center">
                    <div class="form-check form-switch mt-4">
                        <input class="form-check-input" type="checkbox" role="switch" id="is_active" name="is_active"
                            value="1" {{ old('is_active', $industry->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label fw-semibold ms-2" for="is_active">Active Status</label>
                    </div>
                </div>
            </div>

            <h5 class="fw-bold mb-4 border-bottom pb-2">Media</h5>
            <div class="col-md-12">
                <x-admin.components.forms.image-upload name="image" label="Industry Cover Image" aspect="banner"
                    :current="$industry->image ? asset('storage/' . $industry->image) : null" help="Recommended: 800x400px. JPG, PNG, WEBP." />
            </div>

            <div class="d-flex justify-content-end gap-2 mt-4 pt-4 border-top">
                <a href="{{ route('admin.industries') }}" class="btn btn-light">Cancel</a>
                <button type="submit" class="btn primary">
                    <i class="bi bi-save me-1"></i> Save Changes
                </button>
            </div>
        </form>
    </div>
@endsection
