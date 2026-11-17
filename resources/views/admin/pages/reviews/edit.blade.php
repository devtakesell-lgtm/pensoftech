@extends('admin.layouts.admin-master')

@section('title', 'Edit Review — ' . $review->name)

@section('content')
    <div class="heading">
        <div>
            <small>AGENCY ADMIN</small>
            <h1>Edit Review</h1>
            <p>Update customer testimonial information and status.</p>
        </div>
        <div>
            <a href="{{ route('admin.reviews.index') }}" class="btn light">
                <i class="bi bi-arrow-left me-1"></i> Back to Reviews
            </a>
        </div>
    </div>

    @if (session('error'))
        <div class="alert-custom alert-custom-danger mb-3">
            <i class="bi bi-exclamation-triangle-fill"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <form action="{{ route('admin.reviews.update', $review) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Review Details</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="name" class="form-label fw-semibold">Client Name <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="name" id="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name', $review->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-4">
                                <label for="title" class="form-label fw-semibold">Designation / Company <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="title" id="title"
                                    class="form-control @error('title') is-invalid @enderror"
                                    value="{{ old('title', $review->title) }}" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="rating" class="form-label fw-semibold">Star Rating <span
                                        class="text-danger">*</span></label>
                                <select name="rating" id="rating"
                                    class="form-select @error('rating') is-invalid @enderror" required>
                                    @for ($r = 5; $r >= 1; $r--)
                                        <option value="{{ $r }}"
                                            {{ old('rating', $review->rating) == $r ? 'selected' : '' }}>
                                            {{ $r }} {{ Str::plural('Star', $r) }} ({{ str_repeat('★', $r) }})
                                        </option>
                                    @endfor
                                </select>
                                @error('rating')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-4">
                                <label for="sort_order" class="form-label fw-semibold">Sort Order</label>
                                <input type="number" name="sort_order" id="sort_order"
                                    class="form-control @error('sort_order') is-invalid @enderror"
                                    value="{{ old('sort_order', $review->sort_order) }}" min="0">
                                <div class="form-text">Lower numbers appear first.</div>
                                @error('sort_order')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="content" class="form-label fw-semibold">Review / Testimonial <span
                                    class="text-danger">*</span></label>
                            <textarea name="content" id="content" rows="5" class="form-control @error('content') is-invalid @enderror"
                                required>{{ old('content', $review->content) }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Client Avatar</h5>
                    </div>
                    <div class="card-body">
                        <x-admin.components.forms.image-upload name="avatar" label="Profile Photo" :current="$review->avatar_url"
                            aspect="square" />
                        <div class="form-text mt-2">Leave blank to keep existing avatar.</div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Publishing</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" role="switch" id="is_active" name="is_active"
                                value="1" {{ old('is_active', $review->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold" for="is_active">Active & Visible</label>
                        </div>
                        <p class="text-muted small mb-0">Inactive reviews won't be displayed on the public website.</p>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.reviews.index') }}" class="btn light">Cancel</a>
                    <button type="submit" class="btn primary">
                        <i class="bi bi-save me-1"></i> Update Review
                    </button>
                </div>
            </div>
        </div>
    </form>
@endsection
