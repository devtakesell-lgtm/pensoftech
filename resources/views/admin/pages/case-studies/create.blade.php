@extends('admin.layouts.admin-master')

@section('title', 'Create Case Study')

@push('scripts')
    <!-- TinyMCE CDN -->
    {{-- <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: '#content',
            height: 500,
            plugins: 'advlist autolink lists link image charmap preview anchor pagebreak',
            toolbar_mode: 'floating',
            toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
        });
    </script> --}}
@endpush

@section('content')
    <div class="heading">
        <div>
            <a href="{{ route('admin.case-studies.index') }}" class="btn-back">
                <i class="bi bi-arrow-left"></i> Back to Case Studies
            </a>
            <h1>Add New Case Study</h1>
            <p>Publish a success story from a completed project.</p>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert-custom alert-custom-danger mb-4">
            <i class="bi bi-exclamation-triangle-fill"></i>
            <div>
                <strong>Please fix the following errors:</strong>
                <ul class="mb-0 mt-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <form action="{{ route('admin.case-studies.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row">
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="mb-4">
                            <label for="title" class="form-label fw-semibold">Case Study Title <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="title" id="title" class="form-control"
                                value="{{ old('title') }}" required
                                placeholder="e.g., E-Commerce Transformation for Retail Brand">
                        </div>

                        <div class="mb-4">
                            <label for="project_id" class="form-label fw-semibold">Associated Project <span
                                    class="text-danger">*</span></label>
                            <select name="project_id" id="project_id" class="form-select" required>
                                <option value="">Select a completed project</option>
                                @foreach ($projects as $project)
                                    <option value="{{ $project->id }}"
                                        {{ old('project_id') == $project->id ? 'selected' : '' }}>
                                        {{ $project->title }} ({{ $project->client?->name ?? 'No Client' }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="challenge" class="form-label fw-semibold">The Challenge <span
                                        class="text-danger">*</span></label>
                                <textarea name="challenge" id="challenge" class="form-control" rows="4" required
                                    placeholder="What problem did the client face?">{{ old('challenge') }}</textarea>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="solution" class="form-label fw-semibold">Our Solution <span
                                        class="text-danger">*</span></label>
                                <textarea name="solution" id="solution" class="form-control" rows="4" required
                                    placeholder="How did we solve it?">{{ old('solution') }}</textarea>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="result" class="form-label fw-semibold">The Result <span
                                    class="text-danger">*</span></label>
                            <textarea name="result" id="result" class="form-control" rows="3" required
                                placeholder="What was the final outcome?">{{ old('result') }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label for="content" class="form-label fw-semibold">Detailed Content (Story)</label>
                            <textarea name="content" id="content" class="form-control">{{ old('content') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                {{-- Dynamic Metrics Alpine Component --}}
                <div class="card mb-4" x-data="{
                    metrics: {{ json_encode(old('metrics', [['metric_name' => '', 'metric_value' => '', 'metric_suffix' => '']])) }},
                    addMetric() {
                        this.metrics.push({ metric_name: '', metric_value: '', metric_suffix: '' });
                    },
                    removeMetric(index) {
                        if (this.metrics.length > 1) {
                            this.metrics.splice(index, 1);
                        }
                    }
                }">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="card-title fw-bold mb-0">Key Metrics</h5>
                            <button type="button" class="btn btn-sm light" @click="addMetric()">
                                <i class="bi bi-plus"></i> Add
                            </button>
                        </div>

                        <template x-for="(metric, index) in metrics" :key="index">
                            <div class="p-3 bg-light rounded mb-3 border">
                                <div class="d-flex justify-content-end mb-2">
                                    <button type="button" class="btn btn-sm btn-link text-danger p-0"
                                        @click="removeMetric(index)" x-show="metrics.length > 1">
                                        <i class="bi bi-x-circle"></i> Remove
                                    </button>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label small fw-semibold">Metric Name</label>
                                    <input type="text" class="form-control form-control-sm" x-model="metric.metric_name"
                                        :name="'metrics[' + index + '][metric_name]'" placeholder="e.g. Sales Increase">
                                </div>
                                <div class="row">
                                    <div class="col-8">
                                        <label class="form-label small fw-semibold">Value</label>
                                        <input type="text" class="form-control form-control-sm"
                                            x-model="metric.metric_value" :name="'metrics[' + index + '][metric_value]'"
                                            placeholder="e.g. 300">
                                    </div>
                                    <div class="col-4">
                                        <label class="form-label small fw-semibold">Suffix</label>
                                        <input type="text" class="form-control form-control-sm"
                                            x-model="metric.metric_suffix" :name="'metrics[' + index + '][metric_suffix]'"
                                            placeholder="e.g. %">
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title fw-bold mb-3">Media</h5>
                        <x-admin.components.forms.image-upload name="image" label="Cover Image" aspect="banner"
                            help="Recommended: 1200x600px. JPG, PNG, WEBP." />
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title fw-bold mb-3">Publishing</h5>

                        <div class="mb-3">
                            <label for="status" class="form-label fw-semibold">Status <span
                                    class="text-danger">*</span></label>
                            <select name="status" id="status" class="form-select" required>
                                @foreach (\App\Enums\ContentStatus::cases() as $status)
                                    <option value="{{ $status->value }}"
                                        {{ old('status', 'published') === $status->value ? 'selected' : '' }}>
                                        {{ ucfirst($status->value) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="published_at" class="form-label fw-semibold">Publish Date</label>
                            <input type="date" name="published_at" id="published_at" class="form-control"
                                value="{{ old('published_at', now()->format('Y-m-d')) }}">
                        </div>

                        <button type="submit" class="btn primary w-100">
                            <i class="bi bi-cloud-upload me-2"></i> Publish Case Study
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
