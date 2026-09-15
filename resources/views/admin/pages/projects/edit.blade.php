@extends('admin.layouts.admin-master')

@section('title', 'Edit Project')

@section('content')
    <div class="heading">
        <div>
            <small>PROJECT MANAGEMENT</small>
            <h1>Edit Project</h1>
            <p>Update project details, status, and associations.</p>
        </div>
        <div>
            <a href="{{ route('admin.projects.index') }}" class="btn light">
                <i class="bi bi-arrow-left me-1"></i> Back to Projects
            </a>
        </div>
    </div>

    {{-- Validation Errors --}}
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

    <form action="{{ route('admin.projects.update', $project) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Card 1: Core Project Details --}}
        <div class="card form-card mb-4">
            <h3 class="form-card-title">
                <i class="bi bi-journal-text me-2 text-primary"></i> Project Details
            </h3>

            <div class="form-grid-2">
                <div class="form-group">
                    <label class="form-label">Project Title *</label>
                    <input type="text" name="title" value="{{ old('title', $project->title) }}"
                        placeholder="e.g. Website Redesign" required class="form-input">
                </div>

                <div class="form-group">
                    <label class="form-label">Live URL / Project Link</label>
                    <input type="url" name="project_url" value="{{ old('project_url', $project->project_url) }}"
                        placeholder="e.g. https://client-site.com" class="form-input">
                </div>
            </div>

            <div class="form-group mt-3">
                <label class="form-label">Short Description</label>
                <textarea name="short_description" rows="2" class="form-textarea" placeholder="Brief summary of the project...">{{ old('short_description', $project->short_description) }}</textarea>
            </div>

            <div class="form-group mt-3">
                <label class="form-label">Full Description</label>
                <textarea name="description" rows="5" class="form-textarea form-textarea-lg"
                    placeholder="Detailed project description...">{{ old('description', $project->description) }}</textarea>
            </div>
        </div>

        {{-- Card 2: Associations & Status --}}
        <div class="card form-card mb-4">
            <h3 class="form-card-title">
                <i class="bi bi-link-45deg me-2 text-primary"></i> Client & Organization
            </h3>

            <div class="form-grid-3">
                <div class="form-group">
                    <label class="form-label">Client *</label>
                    <select name="client_id" class="form-input" required>
                        <option value="">Select Client</option>
                        @foreach ($clients ?? [] as $client)
                            <option value="{{ $client->id }}"
                                {{ (string) old('client_id', $project->client_id) === (string) $client->id ? 'selected' : '' }}>
                                {{ $client->contact_person }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Industry</label>
                    <select name="industry_id" class="form-input">
                        <option value="">Select Industry</option>
                        @foreach ($industries ?? [] as $industry)
                            <option value="{{ $industry->id }}"
                                {{ (string) old('industry_id', $project->industry_id) === (string) $industry->id ? 'selected' : '' }}>
                                {{ $industry->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Status *</label>
                    @if ($project->status === \App\Enums\ProjectStatus::Completed)
                        <div class="mt-2">
                            <span class="status-badge {{ $project->status->badgeClass() }}">
                                <i class="bi {{ $project->status->icon() }} me-1"></i>
                                {{ $project->status->label() }}
                            </span>
                            <input type="hidden" name="status" value="{{ $project->status->value }}">
                        </div>
                    @else
                        <select name="status" class="form-input" required>
                            @foreach ($statuses ?? [] as $statusOption)
                                <option value="{{ $statusOption->value }}"
                                    {{ old('status', $project->status->value) === $statusOption->value ? 'selected' : '' }}>
                                    {{ $statusOption->label() }}
                                </option>
                            @endforeach
                        </select>
                    @endif
                </div>
            </div>

            <div class="form-group mt-3">
                <label class="form-label d-block">Attached Services</label>
                <div class="row g-2">
                    @php
                        $selectedServices = old('services', $project->services->pluck('id')->toArray());
                    @endphp
                    @foreach ($services ?? [] as $service)
                        <div class="col-md-4 col-sm-6">
                            <label class="d-flex align-items-center gap-2 p-2 border rounded bg-light cursor-pointer">
                                <input type="checkbox" name="services[]" value="{{ $service->id }}"
                                    {{ in_array($service->id, $selectedServices) ? 'checked' : '' }}
                                    class="form-check-input mt-0">
                                <span class="small fw-semibold text-dark">{{ $service->name }}</span>
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Card 3: Timeline & Media --}}
        <div class="card form-card mb-4">
            <h3 class="form-card-title">
                <i class="bi bi-calendar-range me-2 text-primary"></i> Timeline & Media
            </h3>

            <div class="form-grid-3">
                <div class="form-group">
                    <label class="form-label">Start Date</label>
                    <input type="date" name="start_date"
                        value="{{ old('start_date', $project->start_date?->format('Y-m-d')) }}" class="form-input">
                </div>

                <div class="form-group">
                    <label class="form-label">Completion Date</label>
                    <input type="date" name="completion_date"
                        value="{{ old('completion_date', $project->completion_date?->format('Y-m-d')) }}"
                        class="form-input">
                </div>

                <div class="form-group d-flex align-items-end pb-2">
                    <label class="d-flex align-items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_featured" value="1"
                            {{ old('is_featured', $project->is_featured) ? 'checked' : '' }} class="form-check-input">
                        <span class="fw-semibold text-dark">Feature this Project</span>
                    </label>
                </div>
            </div>

            <div class="form-group mt-4">
                <x-admin.components.forms.image-upload name="featured_image" label="Featured Image" :current="$project->featured_image ?? null"
                    aspect="landscape" />
            </div>
        </div>

        {{-- Form Submit Actions --}}
        <div class="d-flex justify-content-end gap-2 mb-5">
            <a href="{{ route('admin.projects.index') }}" class="btn light">
                Cancel
            </a>
            <button type="submit" class="btn primary">
                <i class="bi bi-check-lg me-1"></i> Update Project
            </button>
        </div>
    </form>
@endsection
