@extends('admin.layouts.admin-master')

@section('title', 'Add New Course')

@section('content')
    <div class="heading">
        <div>
            <small>ACADEMY MANAGEMENT</small>
            <h1>Add New Course</h1>
            <p>Create a training course, define schedule, batch size, and pricing.</p>
        </div>
        <div>
            <a href="{{ route('admin.courses.index') }}" class="btn light">
                <i class="bi bi-arrow-left me-1"></i> Back to Courses
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

    <form action="{{ route('admin.courses.store') }}" method="POST" enctype="multipart/form-data" x-data="{ isFree: {{ old('is_free') ? 'true' : 'false' }}, deliveryMode: '{{ old('delivery_mode', 'offline') }}' }">
        @csrf

        {{-- Section 1: Basic Information --}}
        <div class="card form-card mb-4">
            <h3 class="form-card-title">1. Course Details & Classification</h3>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label" for="title">Course Title <span class="text-danger">*</span></label>
                    <input type="text" id="title" name="title"
                        class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}"
                        placeholder="e.g. Practical Laravel Full-Stack Bootcamp" required autofocus>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label" for="slug">URL Slug <span class="text-muted">(Optional)</span></label>
                    <input type="text" id="slug" name="slug"
                        class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug') }}"
                        placeholder="Leave blank to auto-generate">
                    <div class="form-text">Will be auto-generated from title if left empty.</div>
                    @error('slug')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label" for="course_category_id">Category <span class="text-danger">*</span></label>
                    <select id="course_category_id" name="course_category_id"
                        class="form-select @error('course_category_id') is-invalid @enderror" required>
                        <option value="">Select Category</option>
                        @foreach ($categories ?? [] as $category)
                            <option value="{{ $category->id }}"
                                {{ (string) old('course_category_id') === (string) $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('course_category_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label" for="instructor_id">Instructor / Mentor</label>
                    <select id="instructor_id" name="instructor_id"
                        class="form-select @error('instructor_id') is-invalid @enderror">
                        <option value="">Select Instructor (or assign later)</option>
                        @foreach ($instructors ?? [] as $inst)
                            <option value="{{ $inst->id }}"
                                {{ (string) old('instructor_id') === (string) $inst->id ? 'selected' : '' }}>
                                {{ $inst->name }} ({{ $inst->designation }})
                            </option>
                        @endforeach
                    </select>
                    @error('instructor_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label" for="delivery_mode">Delivery Mode <span class="text-danger">*</span></label>
                    <select id="delivery_mode" name="delivery_mode" x-model="deliveryMode"
                        class="form-select @error('delivery_mode') is-invalid @enderror" required>
                        @foreach ($deliveryModes ?? [] as $mode)
                            <option value="{{ $mode->value }}"
                                {{ old('delivery_mode', 'offline') === $mode->value ? 'selected' : '' }}>
                                {{ $mode->label() }}
                            </option>
                        @endforeach
                    </select>
                    @error('delivery_mode')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 mb-3">
                    <label class="form-label" for="subtitle">Subtitle / Highlight</label>
                    <input type="text" id="subtitle" name="subtitle"
                        class="form-control @error('subtitle') is-invalid @enderror" value="{{ old('subtitle') }}"
                        placeholder="One line catchy highlight explaining who this course is for...">
                    @error('subtitle')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Section 2: Batch, Venue & Scheduling --}}
        <div class="card form-card mb-4">
            <h3 class="form-card-title">2. Batch Schedule & Office Venue</h3>
            <div class="row">
                <div class="col-md-3 mb-3">
                    <label class="form-label" for="batch_no">Batch Number</label>
                    <input type="text" id="batch_no" name="batch_no"
                        class="form-control @error('batch_no') is-invalid @enderror"
                        value="{{ old('batch_no', 'Batch 01') }}" placeholder="e.g. Batch 01">
                    @error('batch_no')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-3 mb-3">
                    <label class="form-label" for="max_seats">Maximum Seats</label>
                    <input type="number" id="max_seats" name="max_seats" min="1"
                        class="form-control @error('max_seats') is-invalid @enderror" value="{{ old('max_seats', 15) }}"
                        placeholder="e.g. 15">
                    @error('max_seats')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-3 mb-3">
                    <label class="form-label" for="duration_weeks">Duration (Weeks)</label>
                    <input type="number" id="duration_weeks" name="duration_weeks" min="1"
                        class="form-control @error('duration_weeks') is-invalid @enderror"
                        value="{{ old('duration_weeks', 8) }}">
                    @error('duration_weeks')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-3 mb-3">
                    <label class="form-label" for="total_classes">Total Classes / Lectures</label>
                    <input type="number" id="total_classes" name="total_classes" min="1"
                        class="form-control @error('total_classes') is-invalid @enderror"
                        value="{{ old('total_classes', 24) }}">
                    @error('total_classes')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3" x-show="deliveryMode === 'offline' || deliveryMode === 'hybrid'">
                    <label class="form-label" for="venue">Office Classroom / Venue Address</label>
                    <input type="text" id="venue" name="venue"
                        class="form-control @error('venue') is-invalid @enderror"
                        value="{{ old('venue', 'PenSoftTech Training Lab, Darus Salam Tower, Kollaynpur Dhaka') }}"
                        placeholder="e.g. PenSoftTech Training Lab, Floor 4, Office Address...">
                    @error('venue')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label" for="class_schedule">Class Schedule</label>
                    <input type="text" id="class_schedule" name="class_schedule"
                        class="form-control @error('class_schedule') is-invalid @enderror"
                        value="{{ old('class_schedule', 'শনি ও মঙ্গলবার — সন্ধ্যা ৭:০০টা থেকে রাত ৯:০০টা') }}"
                        placeholder="e.g. শনি ও মঙ্গলবার — সন্ধ্যা ৭:০০টা থেকে রাত ৯:০০টা">
                    @error('class_schedule')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label" for="enrollment_deadline">Application Deadline</label>
                    <input type="date" id="enrollment_deadline" name="enrollment_deadline"
                        class="form-control @error('enrollment_deadline') is-invalid @enderror"
                        value="{{ old('enrollment_deadline') }}">
                    @error('enrollment_deadline')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label" for="start_date">Class Start Date</label>
                    <input type="date" id="start_date" name="start_date"
                        class="form-control @error('start_date') is-invalid @enderror" value="{{ old('start_date') }}">
                    @error('start_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label" for="end_date">Estimated Completion Date</label>
                    <input type="date" id="end_date" name="end_date"
                        class="form-control @error('end_date') is-invalid @enderror" value="{{ old('end_date') }}">
                    @error('end_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Section 3: Pricing & Currency --}}
        <div class="card form-card mb-4">
            <h3 class="form-card-title">3. Pricing & Currency</h3>
            <div class="row">
                <div class="col-12 mb-3">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="is_free" name="is_free" value="1"
                            x-model="isFree" {{ old('is_free') ? 'checked' : '' }}>
                        <label class="form-check-label fw-bold" for="is_free">
                            Free Course (No fee required — application & screening based)
                        </label>
                    </div>
                </div>

                <div class="col-md-4 mb-3" x-show="!isFree">
                    <label class="form-label" for="currency_id">Currency</label>
                    <select id="currency_id" name="currency_id"
                        class="form-select @error('currency_id') is-invalid @enderror">
                        @foreach ($currencies ?? [] as $currency)
                            <option value="{{ $currency->id }}"
                                {{ (string) old('currency_id') === (string) $currency->id || $currency->code === 'BDT' ? 'selected' : '' }}>
                                {{ $currency->name }} ({{ $currency->symbol }})
                            </option>
                        @endforeach
                    </select>
                    @error('currency_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4 mb-3" x-show="!isFree">
                    <label class="form-label" for="price">Regular Fee</label>
                    <input type="number" step="0.01" id="price" name="price"
                        class="form-control @error('price') is-invalid @enderror" value="{{ old('price') }}"
                        placeholder="e.g. 5000.00">
                    @error('price')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4 mb-3" x-show="!isFree">
                    <label class="form-label" for="discount_price">Discounted Fee <span
                            class="text-muted">(Optional)</span></label>
                    <input type="number" step="0.01" id="discount_price" name="discount_price"
                        class="form-control @error('discount_price') is-invalid @enderror"
                        value="{{ old('discount_price') }}" placeholder="e.g. 3500.00">
                    @error('discount_price')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Section 4: Media & Thumbnail --}}
        <div class="card form-card mb-4">
            <h3 class="form-card-title">4. Media & Preview</h3>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <x-admin.components.forms.image-upload name="thumbnail" label="Course Thumbnail"
                        aspect="banner" />
                    @error('thumbnail')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label" for="intro_video_url">Intro / Preview Video Link <span
                            class="text-muted">(YouTube / Vimeo)</span></label>
                    <input type="url" id="intro_video_url" name="intro_video_url"
                        class="form-control @error('intro_video_url') is-invalid @enderror"
                        value="{{ old('intro_video_url') }}" placeholder="https://www.youtube.com/watch?v=...">
                    <div class="form-text">Will be embedded on the course detail page as preview.</div>
                    @error('intro_video_url')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Section 5: Rich Description --}}
        <div class="card form-card mb-4">
            <h3 class="form-card-title">5. Course Overview & Curriculum Description</h3>
            <div class="mb-3">
                <label class="form-label" for="description">Detailed Description <span
                        class="text-danger">*</span></label>
                <textarea id="description" name="description" rows="10"
                    class="form-control tinymce-editor @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- Section 6: Learning Outcomes & Prerequisites --}}
        <div class="card form-card mb-4" x-data="{
            outcomes: {{ json_encode(old('what_you_will_learn', ['PHP 8.3 & Laravel 11 Core', 'Real-world Project Architecture'])) }},
            prereqs: {{ json_encode(old('prerequisites', ['বেসিক প্রোগ্রামিং ও HTML/CSS এর ধারণা'])) }}
        }">
            <h3 class="form-card-title">6. Learning Outcomes & Prerequisites</h3>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">What You Will Learn</label>
                    <template x-for="(outcome, index) in outcomes" :key="index">
                        <div class="input-group mb-2">
                            <input type="text" :name="'what_you_will_learn[' + index + ']'" x-model="outcomes[index]"
                                class="form-control" placeholder="e.g. Advanced Eloquent & Multi-Tenancy">
                            <button type="button" @click="outcomes.splice(index, 1)" class="btn light text-danger"
                                title="Remove">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </div>
                    </template>
                    <button type="button" @click="outcomes.push('')" class="btn light btn-sm d-inline-flex align-items-center gap-1 ms-0 mt-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M12 5v14M5 12h14" />
                        </svg>
                        <span>Add Outcome</span>
                    </button>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Prerequisites / Requirements</label>
                    <template x-for="(prereq, index) in prereqs" :key="index">
                        <div class="input-group mb-2">
                            <input type="text" :name="'prerequisites[' + index + ']'" x-model="prereqs[index]"
                                class="form-control" placeholder="e.g. Basic JavaScript knowledge">
                            <button type="button" @click="prereqs.splice(index, 1)" class="btn light text-danger"
                                title="Remove">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </div>
                    </template>
                    <button type="button" @click="prereqs.push('')" class="btn light btn-sm d-inline-flex align-items-center gap-1 ms-0 mt-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M12 5v14M5 12h14" />
                        </svg>
                        <span>Add Requirement</span>
                    </button>
                </div>
            </div>
        </div>

        {{-- Section 7: Publishing & Status --}}
        <div class="card form-card mb-4">
            <h3 class="form-card-title">7. Publishing Status</h3>
            <div class="row align-items-center">
                <div class="col-md-6 mb-3">
                    <label class="form-label" for="status">Publication Status <span
                            class="text-danger">*</span></label>
                    <select id="status" name="status" class="form-select @error('status') is-invalid @enderror"
                        required>
                        @foreach ($statuses ?? [] as $st)
                            <option value="{{ $st->value }}"
                                {{ old('status', 'draft') === $st->value ? 'selected' : '' }}>
                                {{ $st->label() }}
                            </option>
                        @endforeach
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <div class="form-check form-switch mt-4">
                        <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured"
                            value="1" {{ old('is_featured') ? 'checked' : '' }}>
                        <label class="form-check-label fw-bold" for="is_featured">Featured Course (Highlighted on Homepage
                            & Header)</label>
                    </div>
                </div>
            </div>

            <hr class="my-4">

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.courses.index') }}" class="btn light">Cancel</a>
                <button type="submit" class="btn primary">
                    <i class="bi bi-check-lg me-1"></i> Create Course
                </button>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
    @include('admin.components.tinymce-script')
@endpush
