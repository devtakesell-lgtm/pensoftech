@extends('admin.layouts.admin-master')

@section('title', 'Edit Instructor')

@section('content')
    <div class="heading">
        <div>
            <small>ACADEMY MODULE</small>
            <h1>Edit Instructor / Mentor</h1>
            <p>Update trainer profile and social links.</p>
        </div>
        <div>
            <a href="{{ route('admin.instructors.index') }}" class="btn light">
                <i class="bi bi-arrow-left me-1"></i> Back to Instructors
            </a>
        </div>
    </div>

    <div class="card form-card">
        <form action="{{ route('admin.instructors.update', $instructor) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label" for="name">Full Name <span class="text-danger">*</span></label>
                    <input type="text" id="name" name="name"
                        class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name', $instructor->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label" for="designation">Designation <span class="text-danger">*</span></label>
                    <input type="text" id="designation" name="designation"
                        class="form-control @error('designation') is-invalid @enderror"
                        value="{{ old('designation', $instructor->designation) }}" required>
                    @error('designation')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label" for="user_id">Linked User Account <span class="text-muted">(Optional)</span></label>
                    <select id="user_id" name="user_id" class="form-select @error('user_id') is-invalid @enderror">
                        <option value="">None / External Mentor</option>
                        @foreach ($users ?? [] as $user)
                            <option value="{{ $user->id }}" {{ (string) old('user_id', $instructor->user_id) === (string) $user->id ? 'selected' : '' }}>
                                {{ $user->name }} ({{ $user->email }})
                            </option>
                        @endforeach
                    </select>
                    @error('user_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label" for="skills">Skills <span class="text-muted">(Comma-separated)</span></label>
                    @php
                        $skillsString = is_array($instructor->skills) ? implode(', ', $instructor->skills) : ($instructor->skills ?? '');
                    @endphp
                    <input type="text" id="skills" name="skills"
                        class="form-control @error('skills') is-invalid @enderror"
                        value="{{ old('skills', $skillsString) }}"
                        placeholder="e.g. Laravel, Vue.js, MySQL, Docker">
                    @error('skills')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 mb-3">
                    <x-forms.image-upload name="avatar" label="Instructor Photo" :current="old('avatar', $instructor->avatar)" aspect="avatar" />
                    @error('avatar')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 mb-3">
                    <label class="form-label" for="bio">Biography / Summary</label>
                    <textarea id="bio" name="bio" rows="4"
                        class="form-control @error('bio') is-invalid @enderror">{{ old('bio', $instructor->bio) }}</textarea>
                    @error('bio')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label" for="linkedin">LinkedIn URL</label>
                    <input type="url" id="linkedin" name="social_links[linkedin]"
                        class="form-control"
                        value="{{ old('social_links.linkedin', $instructor->social_links['linkedin'] ?? '') }}">
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label" for="github">GitHub URL</label>
                    <input type="url" id="github" name="social_links[github]"
                        class="form-control"
                        value="{{ old('social_links.github', $instructor->social_links['github'] ?? '') }}">
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label" for="facebook">Facebook / Website URL</label>
                    <input type="url" id="facebook" name="social_links[facebook]"
                        class="form-control"
                        value="{{ old('social_links.facebook', $instructor->social_links['facebook'] ?? '') }}">
                </div>

                <div class="col-12 mb-3">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1"
                            {{ old('is_active', $instructor->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">Active & Available for Courses</label>
                    </div>
                </div>
            </div>

            <hr class="my-4">

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.instructors.index') }}" class="btn light">Cancel</a>
                <button type="submit" class="btn primary">
                    <i class="bi bi-check-lg me-1"></i> Update Instructor
                </button>
            </div>
        </form>
    </div>
@endsection
