@extends('admin.layouts.admin-master')

@section('title', 'Edit Page')

@section('content')
    <div class="heading">
        <div>
            <small>AGENCY ADMIN</small>
            <h1>Edit Page</h1>
            <p>Update the CMS page information.</p>
        </div>
        <div>
            <a href="{{ route('admin.pages.index') }}" class="btn light">
                <i class="bi bi-arrow-left me-1"></i> Back to Pages
            </a>
            <a href="{{ route('admin.pages.show', $page) }}" class="btn light ms-2">
                <i class="bi bi-eye me-1"></i> View Page
            </a>
        </div>
    </div>

    <form action="{{ route('admin.pages.update', $page) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Page Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-4">
                            <label for="title" class="form-label fw-semibold">Page Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $page->title) }}" required>
                            @error('title')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="subtitle" class="form-label fw-semibold">Subtitle</label>
                            <input type="text" name="subtitle" id="subtitle" class="form-control" value="{{ old('subtitle', $page->subtitle) }}">
                            @error('subtitle')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="content" class="form-label fw-semibold">Page Content</label>
                            <textarea name="content" id="content" class="form-control" rows="10">{{ old('content', $page->content) }}</textarea>
                            @error('content')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">SEO Metadata</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-4">
                            <label for="meta_title" class="form-label fw-semibold">Meta Title</label>
                            <input type="text" name="meta_title" id="meta_title" class="form-control" value="{{ old('meta_title', $page->seo?->meta_title) }}" placeholder="Leave blank to use Page Title">
                            @error('meta_title')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="meta_description" class="form-label fw-semibold">Meta Description</label>
                            <textarea name="meta_description" id="meta_description" class="form-control" rows="3">{{ old('meta_description', $page->seo?->meta_description) }}</textarea>
                            @error('meta_description')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-0">
                            <label for="meta_keywords" class="form-label fw-semibold">Meta Keywords</label>
                            <input type="text" name="meta_keywords" id="meta_keywords" class="form-control" value="{{ old('meta_keywords', $page->seo?->meta_keywords) }}" placeholder="e.g. web design, seo, digital marketing">
                            <div class="form-text">Comma-separated keywords.</div>
                            @error('meta_keywords')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Publishing</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-4">
                            <label class="form-label fw-semibold">URL Slug</label>
                            <input type="text" class="form-control bg-light" value="/{{ $page->slug }}" readonly disabled>
                        </div>
                        
                        <div class="mb-4">
                            <label for="status" class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                            <select name="status" id="status" class="form-select" required>
                                @foreach($contentStatuses as $status)
                                    <option value="{{ $status->value }}" {{ old('status', $page->status->value) === $status->value ? 'selected' : '' }}>
                                        {{ ucfirst($status->value) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('status')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="template" class="form-label fw-semibold">Template <span class="text-danger">*</span></label>
                            <select name="template" id="template" class="form-select" required>
                                <option value="default" {{ old('template', $page->template) === 'default' ? 'selected' : '' }}>Default Template</option>
                                <option value="full-width" {{ old('template', $page->template) === 'full-width' ? 'selected' : '' }}>Full Width</option>
                                <option value="contact" {{ old('template', $page->template) === 'contact' ? 'selected' : '' }}>Contact Page</option>
                            </select>
                            @error('template')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="sort_order" class="form-label fw-semibold">Sort Order</label>
                            <input type="number" name="sort_order" id="sort_order" class="form-control" value="{{ old('sort_order', $page->sort_order) }}" min="0">
                            <div class="form-text">Used for ordering pages in menus.</div>
                        </div>
                        
                        <x-admin.components.forms.image-upload 
                            name="image" 
                            label="Featured Image" 
                            :current="$page->featured_image"
                            aspect="banner" 
                        />
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.pages.index') }}" class="btn light">Cancel</a>
                    <button type="submit" class="btn primary">
                        <i class="bi bi-save me-1"></i> Update Page
                    </button>
                </div>
            </div>
        </div>
    </form>
@endsection
