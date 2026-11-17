@extends('admin.layouts.admin-master')

@section('title', 'Add Job Category')

@section('content')
    <div class="heading">
        <div>
            <small>CAREERS MODULE</small>
            <h1>Add Job Category</h1>
            <p>Create a new department or category for job listings.</p>
        </div>
        <div>
            <a href="{{ route('admin.job-categories.index') }}" class="btn light">
                <i class="bi bi-arrow-left me-1"></i> Back to Categories
            </a>
        </div>
    </div>

    <div class="card form-card">
        <form action="{{ route('admin.job-categories.store') }}" method="POST">
            @csrf

            <div class="row">
                {{-- Name --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label" for="name">Category Name <span class="text-danger">*</span></label>
                    <input type="text" id="name" name="name"
                        class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}"
                        placeholder="e.g. Engineering, Marketing, Design" required autofocus>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Slug --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label" for="slug">URL Slug <span class="text-muted">(Optional)</span></label>
                    <input type="text" id="slug" name="slug"
                        class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug') }}"
                        placeholder="Leave blank to auto-generate">
                    <div class="form-text">Will be auto-generated from the name if left empty. Must be unique.</div>
                    @error('slug')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <hr class="my-4">

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.job-categories.index') }}" class="btn light">Cancel</a>
                <button type="submit" class="btn primary">
                    <i class="bi bi-check-lg me-1"></i> Save Category
                </button>
            </div>
        </form>
    </div>
@endsection
