@extends('admin.layouts.admin-master')

@section('title', 'Post New Job')

@section('content')
<div class="heading">
    <div>
        <small>CAREERS MANAGEMENT</small>
        <h1>Post New Job</h1>
        <p>Add a new job opportunity, assign it to a department, and provide details.</p>
    </div>
    <div>
        <a href="{{ route('admin.jobs.index') }}" class="btn light">
            <i class="bi bi-arrow-left me-1"></i> Back to Jobs
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

<form action="{{ route('admin.jobs.store') }}" method="POST">
    @csrf

    {{-- Card 1: Basic Information --}}
    <div class="card form-card">
        <h3 class="form-card-title">
            Basic Information
        </h3>

        <div class="form-grid-3">
            <div class="form-group">
                <label class="form-label">Job Title *</label>
                <input type="text" name="title" value="{{ old('title') }}" placeholder="e.g. Senior Laravel Developer" required class="form-input">
            </div>

            <div class="form-group">
                <label class="form-label">Department (Category)</label>
                <select name="job_category_id" class="form-input">
                    <option value="">No Department</option>
                    @foreach($categories ?? [] as $category)
                        <option value="{{ $category->id }}" {{ (string) old('job_category_id') === (string) $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">URL Slug</label>
                <input type="text" name="slug" value="{{ old('slug') }}" placeholder="e.g. senior-laravel-developer" class="form-input">
                <small class="form-help-text">Leave blank to automatically generate from title.</small>
            </div>
            
            <div class="form-group">
                <label class="form-label">Employment Type</label>
                <select name="employment_type" class="form-input">
                    <option value="">Select Type</option>
                    @foreach($employmentTypes ?? [] as $type)
                        <option value="{{ $type->value }}" {{ old('employment_type') === $type->value ? 'selected' : '' }}>
                            {{ $type->label() }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Location</label>
                <input type="text" name="location" value="{{ old('location') }}" placeholder="e.g. Dhaka, Bangladesh (or Remote)" class="form-input">
            </div>

            <div class="form-group">
                <label class="form-label">Experience Required</label>
                <input type="text" name="experience" value="{{ old('experience') }}" placeholder="e.g. 3-5 Years" class="form-input">
            </div>

            <div class="form-group">
                <label class="form-label">Vacancy</label>
                <input type="number" name="vacancy" value="{{ old('vacancy', 1) }}" min="1" class="form-input">
            </div>

            <div class="form-group">
                <label class="form-label">Application Deadline</label>
                <input type="date" name="deadline" value="{{ old('deadline') }}" class="form-input">
            </div>
        </div>
    </div>

    {{-- Card 2: Job Details (TinyMCE) --}}
    <div class="card form-card">
        <h3 class="form-card-title">
            Job Details
        </h3>

        <div class="form-group mt-3">
            <label class="form-label">Job Description *</label>
            <textarea name="description" rows="5" class="form-textarea form-textarea-lg tinymce-editor">{{ old('description') }}</textarea>
        </div>

        <div class="form-group mt-4">
            <label class="form-label">Requirements</label>
            <textarea name="requirements" rows="5" class="form-textarea form-textarea-lg tinymce-editor">{{ old('requirements') }}</textarea>
        </div>
        
        <div class="form-group mt-4">
            <label class="form-label">Benefits</label>
            <textarea name="benefits" rows="5" class="form-textarea form-textarea-lg tinymce-editor">{{ old('benefits') }}</textarea>
        </div>
    </div>

    {{-- Card 3: Publishing & Visibility --}}
    <div class="card form-card">
        <h3 class="form-card-title">
            Publishing
        </h3>

        <div class="form-grid-2 mb-3">
            <div class="form-group">
                <label class="form-label">Publication Status *</label>
                <select name="status" required class="form-input">
                    @foreach($statuses ?? [] as $status)
                        <option value="{{ $status->value }}" {{ old('status', 'draft') === $status->value ? 'selected' : '' }}>
                            {{ $status->label() }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    {{-- Actions --}}
    <div class="form-actions">
        <button type="submit" class="btn primary">
            <i class="bi bi-check2 me-1"></i> Post Job
        </button>
        <a href="{{ route('admin.jobs.index') }}" class="btn light">
            Cancel
        </a>
    </div>
</form>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/tinymce@6.8.3/tinymce.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
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
            branding: false
        });
    });
</script>
@endpush
