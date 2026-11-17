@extends('admin.layouts.admin-master')

@section('title', 'Edit Job')

@section('content')
<div class="heading">
    <div>
        <small>CAREERS MANAGEMENT</small>
        <h1>Edit Job</h1>
        <p>Modify the details of an existing job posting.</p>
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

<form action="{{ route('admin.jobs.update', $job) }}" method="POST">
    @csrf
    @method('PUT')

    {{-- Card 1: Basic Information --}}
    <div class="card form-card">
        <h3 class="form-card-title">
            Basic Information
        </h3>

        <div class="form-grid-3">
            <div class="form-group">
                <label class="form-label">Job Title *</label>
                <input type="text" name="title" value="{{ old('title', $job->title) }}" required class="form-input">
            </div>

            <div class="form-group">
                <label class="form-label">Department (Category)</label>
                <select name="job_category_id" class="form-input">
                    <option value="">No Department</option>
                    @foreach($categories ?? [] as $category)
                        <option value="{{ $category->id }}" {{ (string) old('job_category_id', $job->job_category_id) === (string) $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">URL Slug</label>
                <input type="text" name="slug" value="{{ old('slug', $job->slug) }}" class="form-input">
                <small class="form-help-text">Leave blank to automatically generate from title.</small>
            </div>
            
            <div class="form-group">
                <label class="form-label">Employment Type</label>
                <select name="employment_type" class="form-input">
                    <option value="">Select Type</option>
                    @foreach($employmentTypes ?? [] as $type)
                        <option value="{{ $type->value }}" {{ old('employment_type', $job->employment_type) === $type->value ? 'selected' : '' }}>
                            {{ $type->label() }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Location</label>
                <input type="text" name="location" value="{{ old('location', $job->location) }}" class="form-input">
            </div>

            <div class="form-group">
                <label class="form-label">Experience Required</label>
                <input type="text" name="experience" value="{{ old('experience', $job->experience) }}" class="form-input">
            </div>

            <div class="form-group">
                <label class="form-label">Vacancy</label>
                <input type="number" name="vacancy" value="{{ old('vacancy', $job->vacancy) }}" min="1" class="form-input">
            </div>

            <div class="form-group">
                <label class="form-label">Application Deadline</label>
                <input type="date" name="deadline" value="{{ old('deadline', $job->deadline?->format('Y-m-d')) }}" class="form-input">
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
            <textarea name="description" rows="5" class="form-textarea form-textarea-lg tinymce-editor">{{ old('description', $job->description) }}</textarea>
        </div>

        <div class="form-group mt-4">
            <label class="form-label">Requirements</label>
            <textarea name="requirements" rows="5" class="form-textarea form-textarea-lg tinymce-editor">{{ old('requirements', $job->requirements) }}</textarea>
        </div>
        
        <div class="form-group mt-4">
            <label class="form-label">Benefits</label>
            <textarea name="benefits" rows="5" class="form-textarea form-textarea-lg tinymce-editor">{{ old('benefits', $job->benefits) }}</textarea>
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
                        <option value="{{ $status->value }}" {{ old('status', $job->status) === $status->value ? 'selected' : '' }}>
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
            <i class="bi bi-check2 me-1"></i> Update Job
        </button>
        <a href="{{ route('admin.jobs.index') }}" class="btn light">
            Cancel
        </a>
    </div>
</form>
@endsection

@push('scripts')
    @include('admin.components.tinymce-script')
@endpush
