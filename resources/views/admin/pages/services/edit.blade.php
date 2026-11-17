@extends('admin.layouts.admin-master')

@section('title', 'Edit Service: ' . $service->name)

@section('content')
<div class="heading">
    <div>
        <small>SERVICES MANAGEMENT</small>
        <h1>Edit Service: {{ $service->name }}</h1>
        <p>Update service details, adjust categorization, update media assets, or change publication status.</p>
    </div>
    <div>
        <a href="{{ route('admin.services') }}" class="btn light">
            <i class="bi bi-arrow-left me-1"></i> Back to Services
        </a>
    </div>
</div>

{{-- Validation Errors --}}
@if($errors->any())
    <div class="alert-custom alert-custom-danger">
        <div>
            <strong>Please resolve the following issues:</strong>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif

<form action="{{ route('admin.services.update', $service) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    {{-- Card 1: Basic Information --}}
    <div class="card form-card">
        <h3 class="form-card-title">
            Service Information
        </h3>

        <div class="form-grid-3">
            <div class="form-group">
                <label class="form-label">Service Name *</label>
                <input type="text" name="name" value="{{ old('name', $service->name) }}" required class="form-input">
            </div>

            <div class="form-group">
                <label class="form-label">Category *</label>
                <select name="service_category_id" required class="form-input">
                    <option value="">Select Category</option>
                    @foreach($categories ?? [] as $category)
                        <option value="{{ $category->id }}" {{ (string) old('service_category_id', $service->service_category_id) === (string) $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">URL Slug *</label>
                <input type="text" name="slug" value="{{ old('slug', $service->slug) }}" required class="form-input">
                <small class="form-help-text">Unique URL identifier for this service.</small>
            </div>
        </div>

        <div class="form-group mt-3">
            <label class="form-label">Short Summary</label>
            <textarea name="short_description" rows="2" class="form-textarea">{{ old('short_description', $service->short_description) }}</textarea>
        </div>

        <div class="form-group mt-3">
            <label class="form-label">Full Service Description</label>
            <textarea name="description" rows="5" class="form-textarea form-textarea-lg">{{ old('description', $service->description) }}</textarea>
        </div>
    </div>

    {{-- Card 2: Visual Assets & Iconography --}}
    <div class="card form-card">
        <h3 class="form-card-title">
            Visual Assets & Iconography
        </h3>

        <div class="form-grid-3">
            <div class="form-group">
                <label class="form-label">Bootstrap Icon Class</label>
                <input type="text" name="icon" value="{{ old('icon', $service->icon) }}" placeholder="e.g. bi-code-slash" class="form-input">
                <small class="form-help-text">e.g. bi-code-slash, bi-phone, bi-palette, bi-graph-up</small>
            </div>

            <div class="form-group">
                <label class="form-label">Featured Thumbnail</label>
                <input type="file" name="featured_image" accept="image/*" class="form-input">
                @if($service->featured_image)
                    <div class="image-preview-wrapper">
                        <img src="{{ asset('storage/' . $service->featured_image) }}" alt="Thumbnail Preview" class="image-preview-thumb">
                        <small class="text-muted">Current thumbnail (uploading a new file will replace this)</small>
                    </div>
                @else
                    <small class="form-help-text">No image currently uploaded (Max 2MB)</small>
                @endif
            </div>

            <div class="form-group">
                <label class="form-label">Header Banner Image</label>
                <input type="file" name="banner_image" accept="image/*" class="form-input">
                @if($service->banner_image)
                    <div class="image-preview-wrapper">
                        <img src="{{ asset('storage/' . $service->banner_image) }}" alt="Banner Preview" class="image-preview-banner">
                        <small class="text-muted">Current banner (uploading a new file will replace this)</small>
                    </div>
                @else
                    <small class="form-help-text">No banner currently uploaded (Max 3MB)</small>
                @endif
            </div>
        </div>
    </div>

    {{-- Card 3: Publishing & Visibility --}}
    <div class="card form-card">
        <h3 class="form-card-title">
            Publishing & Visibility
        </h3>

        <div class="form-grid-2 mb-3">
            <div class="form-group">
                <label class="form-label">Publication Status *</label>
                <select name="status" required class="form-input">
                    @foreach($statuses ?? [] as $status)
                        <option value="{{ $status->value }}" {{ old('status', $service->status->value) === $status->value ? 'selected' : '' }}>
                            {{ $status->label() }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Display Sort Order</label>
                <input type="number" name="sort_order" value="{{ old('sort_order', $service->sort_order) }}" min="0" class="form-input">
                <small class="form-help-text">Lower numbers appear first in listings.</small>
            </div>
        </div>

        <div class="form-toggle-card">
            <input type="hidden" name="is_featured" value="0">
            <input type="checkbox" name="is_featured" value="1" id="is_featured" {{ old('is_featured', $service->is_featured ? '1' : '0') == '1' ? 'checked' : '' }} class="form-toggle-input">
            <div>
                <label for="is_featured" class="form-toggle-label">
                    Feature on Homepage & Navigation
                </label>
                <small class="form-toggle-desc">
                    Featured services are prominently highlighted in the agency homepage showcase and top navigation menus.
                </small>
            </div>
        </div>
    </div>

    {{-- Actions --}}
    <div class="form-actions">
        <button type="submit" class="btn primary">
            <i class="bi bi-check2 me-1"></i> Save Changes
        </button>
        <a href="{{ route('admin.services') }}" class="btn light">
            Cancel
        </a>
    </div>
</form>
@endsection
