@extends('admin.layouts.admin-master')

@section('title', 'Add Course Category')

@section('content')
    <div class="heading">
        <div>
            <small>ACADEMY MODULE</small>
            <h1>Add Course Category</h1>
            <p>Create a new training track or category.</p>
        </div>
        <div>
            <a href="{{ route('admin.course-categories.index') }}" class="btn light">
                <i class="bi bi-arrow-left me-1"></i> Back to Categories
            </a>
        </div>
    </div>

    <div class="card form-card">
        <form action="{{ route('admin.course-categories.store') }}" method="POST">
            @csrf

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label" for="name">Category Name <span class="text-danger">*</span></label>
                    <input type="text" id="name" name="name"
                        class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}"
                        placeholder="e.g. Web Development, Cyber Security" required autofocus>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label" for="slug">URL Slug <span class="text-muted">(Optional)</span></label>
                    <input type="text" id="slug" name="slug"
                        class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug') }}"
                        placeholder="Leave blank to auto-generate">
                    <div class="form-text">Will be auto-generated from name if left empty.</div>
                    @error('slug')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label" for="icon">Bootstrap Icon Class</label>
                    <input type="text" id="icon" name="icon"
                        class="form-control @error('icon') is-invalid @enderror" value="{{ old('icon', 'bi-code-slash') }}"
                        placeholder="e.g. bi-code-slash, bi-palette, bi-phone">
                    @error('icon')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label" for="order">Display Order</label>
                    <input type="number" id="order" name="order" min="0"
                        class="form-control @error('order') is-invalid @enderror" value="{{ old('order', 0) }}">
                    @error('order')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 mb-3">
                    <label class="form-label" for="description">Short Description</label>
                    <textarea id="description" name="description" rows="3"
                        class="form-control @error('description') is-invalid @enderror"
                        placeholder="Brief overview of what this track covers...">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 mb-3">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1"
                            {{ old('is_active', true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">Active & Visible in Frontend</label>
                    </div>
                </div>
            </div>

            <hr class="my-4">

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.course-categories.index') }}" class="btn light">Cancel</a>
                <button type="submit" class="btn primary">
                    <i class="bi bi-check-lg me-1"></i> Save Category
                </button>
            </div>
        </form>
    </div>
@endsection
