@extends('admin.layouts.admin-master')

@section('title', 'Create Blog Category')

@section('content')
<div class="heading">
    <div>
        <small>BLOG MANAGEMENT</small>
        <h1>Add Category</h1>
        <p>Create a new category to group your blog posts.</p>
    </div>
    <div>
        <a href="{{ route('admin.blog-categories.index') }}" class="btn light">
            <i class="bi bi-arrow-left me-1"></i> Back to Categories
        </a>
    </div>
</div>

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

<form action="{{ route('admin.blog-categories.store') }}" method="POST">
    @csrf

    <div class="card form-card mb-4">
        <h3 class="form-card-title">
            <i class="bi bi-grid-fill me-2 text-primary"></i> Category Details
        </h3>

        <div class="form-grid-2">
            <div class="form-group">
                <label class="form-label">Category Name *</label>
                <input type="text" name="name" value="{{ old('name') }}" placeholder="e.g. Technology" required class="form-input">
                <small class="form-text text-muted mt-1">The slug will be automatically generated from the name.</small>
            </div>
            
            <div class="form-group">
                <label class="form-label">Status</label>
                <div class="mt-2">
                    <div class="form-check form-switch d-inline-block">
                        <input class="form-check-input cursor-pointer" type="checkbox" role="switch" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} >
                        <label class="form-check-label ms-2 pt-1 cursor-pointer" for="is_active">Active (Visible)</label>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group mt-3">
            <label class="form-label">Description</label>
            <textarea name="description" rows="3" placeholder="Brief description of this category..." class="form-textarea">{{ old('description') }}</textarea>
        </div>
    </div>

    <div class="d-flex justify-content-end gap-2 mb-5">
        <a href="{{ route('admin.blog-categories.index') }}" class="btn light">
            Cancel
        </a>
        <button type="submit" class="btn primary">
            <i class="bi bi-check-lg me-1"></i> Save Category
        </button>
    </div>
</form>
@endsection
