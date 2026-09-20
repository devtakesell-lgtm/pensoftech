@extends('admin.layouts.admin-master')

@section('title', 'Edit Blog Tag')

@section('content')
<div class="heading">
    <div>
        <small>BLOG MANAGEMENT</small>
        <h1>Edit Tag</h1>
        <p>Update tag details.</p>
    </div>
    <div>
        <a href="{{ route('admin.blog-tags.index') }}" class="btn light">
            <i class="bi bi-arrow-left me-1"></i> Back to Tags
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

<form action="{{ route('admin.blog-tags.update', $blogTag) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="card form-card mb-4">
        <h3 class="form-card-title">
            <i class="bi bi-tag-fill me-2 text-primary"></i> Tag Details
        </h3>

        <div class="form-grid-2">
            <div class="form-group">
                <label class="form-label">Tag Name *</label>
                <input type="text" name="name" value="{{ old('name', $blogTag->name) }}" required class="form-input">
                <small class="form-text text-muted mt-1">Current slug: <code>{{ $blogTag->slug }}</code></small>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-end gap-2 mb-5">
        <a href="{{ route('admin.blog-tags.index') }}" class="btn light">
            Cancel
        </a>
        <button type="submit" class="btn primary">
            <i class="bi bi-check-lg me-1"></i> Update Tag
        </button>
    </div>
</form>
@endsection
