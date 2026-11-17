@extends('admin.layouts.admin-master')

@section('title', 'Edit Category: ' . $category->name)

@section('content')
<div class="heading">
    <div>
        <small>SERVICES MODULE</small>
        <h1>Edit Service Category</h1>
        <p>Update category information, visual assets, display order, or visibility status.</p>
    </div>
    <div>
        <a href="{{ route('admin.service-categories.index') }}" class="btn light">
            <i class="bi bi-arrow-left me-1"></i> Back to Categories
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

<form action="{{ route('admin.service-categories.update', $category) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    {{-- Card 1: Category Information --}}
    <div class="card form-card">
        <h3 class="form-card-title">
            Category Information
        </h3>

        <div class="row g-3">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-label">Category Name *</label>
                    <input type="text" name="name" value="{{ old('name', $category->name) }}" required class="form-input">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-label">URL Slug *</label>
                    <input type="text" name="slug" value="{{ old('slug', $category->slug) }}" required class="form-input">
                    <small class="form-help-text">Unique URL identifier for this category.</small>
                </div>
            </div>

            <div class="col-12">
                <div class="form-group">
                    <label class="form-label">Short Summary</label>
                    <textarea name="short_description" rows="2" placeholder="Brief overview of this service category..." class="form-textarea">{{ old('short_description', $category->short_description) }}</textarea>
                </div>
            </div>

            <div class="col-12">
                <div class="form-group">
                    <label class="form-label">Full Description</label>
                    <textarea name="description" rows="4" placeholder="Comprehensive description for landing and archive pages..." class="form-textarea form-textarea-lg">{{ old('description', $category->description) }}</textarea>
                </div>
            </div>
        </div>
    </div>

    {{-- Card 2: Visual Assets & Iconography --}}
    <div class="card form-card">
        <h3 class="form-card-title">
            Visual Assets & Iconography
        </h3>

        <div class="row g-3">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-label">Bootstrap Icon Class</label>
                    <input type="text" name="icon" value="{{ old('icon', $category->icon) }}" placeholder="e.g. bi-code-slash" class="form-input">
                    <small class="form-help-text">e.g. bi-code-slash, bi-phone, bi-palette, bi-cloud, bi-shield-check</small>
                    @if($category->icon)
                        <div class="mt-2 d-flex align-items-center gap-2">
                            <span class="text-muted small">Current Icon:</span>
                            <i class="bi {{ $category->icon }} fs-5 text-primary"></i>
                        </div>
                    @endif
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-label">Category Header Image</label>
                    <input type="file" name="image" accept="image/*" class="form-input">
                    <small class="form-help-text">Leave blank to keep existing image. (Max 2MB: JPG, PNG, WebP)</small>

                    @if($category->image)
                        <div class="category-preview-wrapper mt-2">
                            <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="category-preview-thumb">
                            <div>
                                <span class="d-block text-muted small fw-semibold">Current Stored Image</span>
                                <small class="text-muted">Uploading a new file will replace this image.</small>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Card 3: Display & Status --}}
    <div class="card form-card">
        <h3 class="form-card-title">
            Display & Visibility
        </h3>

        <div class="row g-3 align-items-center">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-label">Sort Order</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', $category->sort_order) }}" min="0" class="form-input">
                    <small class="form-help-text">Lower numbers appear first in lists and menus (0, 1, 2...).</small>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-label d-block">Status</label>
                    <div class="form-check form-switch mt-2">
                        <input class="form-check-input" type="checkbox" role="switch" id="is_active" name="is_active" value="1" {{ old('is_active', $category->is_active ? '1' : '0') == '1' ? 'checked' : '' }}>
                        <label class="form-check-label fw-semibold" for="is_active">Active & Visible on Website</label>
                    </div>
                    <small class="form-help-text">Inactive categories hide associated services from the public catalog.</small>
                </div>
            </div>
        </div>
    </div>

    {{-- Action Footer --}}
    <div class="form-actions-footer">
        <a href="{{ route('admin.service-categories.index') }}" class="btn light">
            Cancel
        </a>
        <button type="submit" class="btn primary">
            <i class="bi bi-check2 me-1"></i> Save Changes
        </button>
    </div>
</form>
@endsection
