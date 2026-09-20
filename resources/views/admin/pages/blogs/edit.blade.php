@extends('admin.layouts.admin-master')

@section('title', 'Edit Blog Post')

@section('content')
    <div class="heading">
        <div>
            <small>BLOG MANAGEMENT</small>
            <h1>Edit Post</h1>
            <p>Update your blog article.</p>
        </div>
        <div>
            <a href="{{ route('admin.blog.index') }}" class="btn light">
                <i class="bi bi-arrow-left me-1"></i> Back to Posts
            </a>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert-custom alert-custom-danger">
            <div>
                <strong>Please resolve the following issues:</strong>
                <ul class="mb-0 mt-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <form action="{{ route('admin.blog.update', $blog) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="card form-card mb-4">
            <h3 class="form-card-title">
                <i class="bi bi-journal-text me-2 text-primary"></i> General Information
            </h3>

            <div class="form-grid-2">
                <div class="form-group">
                    <label class="form-label">Post Title *</label>
                    <input type="text" name="title" value="{{ old('title', $blog->title) }}" required
                        class="form-input">
                    <small class="form-text text-muted mt-1">Current slug: <code>{{ $blog->slug }}</code></small>
                </div>

                <div class="form-group">
                    <label class="form-label">Category *</label>
                    <select name="blog_category_id" class="form-input" required>
                        <option value="">Select Category...</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ old('blog_category_id', $blog->blog_category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group mt-3">
                <label class="form-label">Tags</label>
                <select name="tags[]" class="form-input select2-tags" multiple="multiple"
                    data-placeholder="Select Tags...">
                    @php
                        $selectedTags = old('tags', $blog->tags->pluck('id')->toArray());
                    @endphp
                    @foreach ($tags as $tag)
                        <option value="{{ $tag->id }}" {{ in_array($tag->id, $selectedTags) ? 'selected' : '' }}>
                            {{ $tag->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group mt-3">
                <label class="form-label">Excerpt</label>
                <textarea name="excerpt" rows="3" class="form-textarea">{{ old('excerpt', $blog->excerpt) }}</textarea>
            </div>

            <div class="form-group mt-3">
                <label class="form-label">Status *</label>
                <select name="status" class="form-input w-auto" required>
                    @foreach (\App\Enums\ContentStatus::cases() as $status)
                        <option value="{{ $status->value }}"
                            {{ old('status', $blog->status->value) === $status->value ? 'selected' : '' }}>
                            {{ $status->label() }}
                        </option>
                    @endforeach
                </select>
                @if ($blog->published_at)
                    <small class="form-text text-muted d-block mt-2">Originally published on
                        {{ $blog->published_at->format('F d, Y h:i A') }}</small>
                @endif
            </div>
        </div>

        <div class="card form-card mb-4">
            <h3 class="form-card-title">
                <i class="bi bi-file-richtext me-2 text-primary"></i> Content & Media
            </h3>

            <div class="form-group mb-4">
                {{-- <x-forms.image-upload
                name="featured_image"
                label="Featured Image"
                :current="$blog->featured_image"
                aspect="banner"
            /> --}}
                <x-admin.components.forms.image-upload name="featured_image" label="Featured Image" aspect="landscape"
                    :current="$blog->featured_image" help="Recommended: JPG, PNG, WEBP." />

            </div>

            <div class="form-group">
                <label class="form-label">Article Content</label>
                <textarea name="content" class="form-textarea tinymce-editor" rows="15">{{ old('content', $blog->content) }}</textarea>
            </div>
        </div>

        <div class="card form-card mb-4">
            <h3 class="form-card-title">
                <i class="bi bi-search me-2 text-primary"></i> SEO Meta Data
            </h3>

            <div class="form-grid-2">
                <div class="form-group">
                    <label class="form-label">Meta Title</label>
                    <input type="text" name="meta_title" value="{{ old('meta_title', $blog->seoMeta?->meta_title) }}"
                        class="form-input" placeholder="Optimal length is 50-60 characters">
                </div>

                <div class="form-group">
                    <label class="form-label">Meta Description</label>
                    <textarea name="meta_description" rows="2" class="form-textarea"
                        placeholder="Optimal length is 150-160 characters">{{ old('meta_description', $blog->seoMeta?->meta_description) }}</textarea>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2 mb-5">
            <a href="{{ route('admin.blog.index') }}" class="btn light">
                Cancel
            </a>
            <button type="submit" class="btn primary">
                <i class="bi bi-check-lg me-1"></i> Update Post
            </button>
        </div>
    </form>
@endsection

@push('styles')
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        /* Modern Select2 Styling */
        .select2-container--default .select2-selection--multiple {
            border: 1px solid var(--border-color) !important;
            border-radius: var(--radius-md) !important;
            min-height: 42px !important;
            padding: 4px 8px !important;
            list-style: none !important;
        }

        .select2-container--default.select2-container--focus .select2-selection--multiple {
            border-color: var(--primary) !important;
            outline: 0 !important;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25) !important;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: var(--primary-subtle) !important;
            border: 1px solid var(--primary) !important;
            color: var(--primary) !important;
            border-radius: 20px !important;
            padding: 2px 8px !important;
            margin-top: 4px !important;
            display: inline-flex !important;
            align-items: center !important;
            list-style: none !important;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice__display {
            padding-left: 5px !important;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
            color: var(--primary) !important;
            margin-right: 5px !important;
            border-right: none !important;
            position: relative !important;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover {
            background-color: transparent !important;
            color: var(--danger) !important;
        }

        .select2-container .select2-search--inline .select2-search__field {
            margin-top: 5px !important;
        }

        /* Fix TinyMCE SVG Icons getting hidden by global resets */
        .tox .tox-tbtn svg {
            display: block !important;
        }
    </style>
@endpush

@push('scripts')
    <!-- TinyMCE -->
    <script src="https://cdn.jsdelivr.net/npm/tinymce@6.8.3/tinymce.min.js"></script>
    <!-- Select2 JS -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize TinyMCE
            tinymce.init({
                selector: '.tinymce-editor',
                height: 400,
                menubar: true,
                plugins: [
                    'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                    'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                    'insertdatetime', 'media', 'table', 'wordcount'
                ],
                toolbar: 'undo redo | blocks | ' +
                    'bold italic forecolor backcolor | alignleft aligncenter ' +
                    'alignright alignjustify | bullist numlist outdent indent | ' +
                    'link image media table | removeformat | code fullscreen',
                content_style: 'body { font-family:Inter,Helvetica,Arial,sans-serif; font-size:14px }',
                promotion: false,
                branding: false,
            });

            // Initialize Select2
            $(document).ready(function() {
                $('.select2-tags').select2({
                    placeholder: "Select tags...",
                    allowClear: true,
                    width: '100%'
                });
            });
        });
    </script>
@endpush
