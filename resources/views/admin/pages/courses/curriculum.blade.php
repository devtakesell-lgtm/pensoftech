@extends('admin.layouts.admin-master')

@section('title', 'Curriculum Builder — ' . $course->title)

@section('content')
    <div x-data="curriculumBuilder()">
        <div class="heading">
            <div>
                <small>CURRICULUM BUILDER</small>
                <h1>{{ $course->title }}</h1>
                <p>
                    Organize modules (chapters) and lessons (office classes, live sessions, videos, notes & assignments).
                    @if ($course->batch_no)
                        <span class="badge bg-secondary-subtle text-secondary border ms-1">{{ $course->batch_no }}</span>
                    @endif
                </p>
            </div>
            <div class="d-flex gap-2">
                <button type="button" class="btn primary d-inline-flex align-items-center gap-1" @click="openAddModule()">
                    <i class="bi bi-plus-lg"></i> Add Module
                </button>
                <a href="{{ route('admin.courses.edit', $course) }}" class="btn light d-inline-flex align-items-center gap-1">
                    <i class="bi bi-pencil"></i> Edit Course
                </a>
                <a href="{{ route('admin.courses.index') }}" class="btn light d-inline-flex align-items-center gap-1">
                    <i class="bi bi-arrow-left"></i> Back
                </a>
            </div>
        </div>

        {{-- Flash Alerts --}}
        @if (session('success'))
            <div class="alert-custom alert-custom-success mb-3">
                <i class="bi bi-check-circle-fill"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert-custom alert-custom-danger mb-3">
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

        {{-- Modules List --}}
        @forelse ($course->modules as $module)
            <div class="card mb-4 border">
                <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                    <div>
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle">
                                Module {{ $module->order }}
                            </span>
                            <h5 class="mb-0 fw-bold">{{ $module->title }}</h5>
                            <span class="text-muted small">({{ $module->lessons->count() }}
                                {{ Str::plural('lesson', $module->lessons->count()) }})</span>
                        </div>
                        @if ($module->description)
                            <p class="text-muted small mb-0 mt-1">{{ $module->description }}</p>
                        @endif
                    </div>

                    <div class="d-flex align-items-center gap-1">
                        <button type="button" class="btn light btn-sm d-inline-flex align-items-center gap-1"
                            @click="openAddLesson({{ $module->id }}, '{{ addslashes($module->title) }}')">
                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M12 5v14M5 12h14" />
                            </svg> Add Lesson
                        </button>
                        <button type="button" class="btn light icon-btn" title="Edit Module"
                            @click="openEditModule({{ Js::from($module) }})">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <form action="{{ route('admin.courses.modules.destroy', [$course, $module]) }}" method="POST"
                            onsubmit="return confirm('Delete this module and all its lessons?');" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn light icon-btn text-danger" title="Delete Module">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>

                <div class="card-body p-0">
                    @if ($module->lessons->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 60px;">#</th>
                                        <th>LESSON TITLE</th>
                                        <th>TYPE</th>
                                        <th>SCHEDULE / DURATION</th>
                                        <th>RESOURCES / LINKS</th>
                                        <th class="text-end">ACTIONS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($module->lessons as $lesson)
                                        <tr>
                                            <td><span class="text-muted fw-semibold">{{ $lesson->order }}</span></td>
                                            <td>
                                                <div class="fw-semibold text-dark">{{ $lesson->title }}</div>
                                                @if ($lesson->notes)
                                                    <div class="text-muted small text-truncate" style="max-width: 320px;">
                                                        {{ Str::limit($lesson->notes, 70) }}
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge bg-light text-dark border">
                                                    <i class="bi {{ $lesson->lesson_type->icon() }} me-1 text-primary"></i>
                                                    {{ $lesson->lesson_type->label() }}
                                                </span>
                                            </td>
                                            <td>
                                                @if ($lesson->duration_minutes)
                                                    <div class="small"><i
                                                            class="bi bi-clock me-1"></i>{{ $lesson->duration_minutes }}
                                                        min</div>
                                                @endif
                                                @if ($lesson->class_date_time)
                                                    <div class="small text-muted"><i
                                                            class="bi bi-calendar-event me-1"></i>{{ $lesson->class_date_time->format('d M Y, h:i A') }}
                                                    </div>
                                                @endif
                                                @if (!$lesson->duration_minutes && !$lesson->class_date_time)
                                                    <span class="text-muted small">—</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex flex-wrap gap-1">
                                                    @if ($lesson->video_url)
                                                        <a href="{{ $lesson->video_url }}" target="_blank"
                                                            class="badge bg-danger-subtle text-danger border text-decoration-none">
                                                            <i
                                                                class="bi bi-play-btn me-1"></i>{{ ucfirst($lesson->video_provider ?? 'Video') }}
                                                        </a>
                                                    @endif
                                                    @if ($lesson->meeting_link)
                                                        <a href="{{ $lesson->meeting_link }}" target="_blank"
                                                            class="badge bg-info-subtle text-info border text-decoration-none">
                                                            <i class="bi bi-camera-video me-1"></i>Meet Link
                                                        </a>
                                                    @endif
                                                    @if ($lesson->attachment_file)
                                                        <a href="{{ asset('storage/' . $lesson->attachment_file) }}"
                                                            target="_blank"
                                                            class="badge bg-success-subtle text-success border text-decoration-none">
                                                            <i class="bi bi-file-earmark-arrow-down me-1"></i>File
                                                        </a>
                                                    @endif
                                                    @if (!$lesson->video_url && !$lesson->meeting_link && !$lesson->attachment_file)
                                                        <span class="text-muted small">None</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="text-end">
                                                <div class="d-inline-flex gap-1">
                                                    <button type="button" class="btn light icon-btn" title="Edit Lesson"
                                                        @click="openEditLesson({{ Js::from($lesson) }}, '{{ addslashes($module->title) }}')">
                                                        <i class="bi bi-pencil"></i>
                                                    </button>
                                                    <form
                                                        action="{{ route('admin.courses.lessons.destroy', [$course, $lesson]) }}"
                                                        method="POST" onsubmit="return confirm('Delete this lesson?');"
                                                        class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn light icon-btn text-danger"
                                                            title="Delete Lesson">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4 text-muted small">
                            No lessons added to this module yet. Click <strong>Add Lesson</strong> to get started.
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="card text-center py-5">
                <div class="mb-2 text-muted"><i class="bi bi-journal-plus fs-1"></i></div>
                <h5>No Curriculum Modules Yet</h5>
                <p class="text-muted small mb-3">Start building your course syllabus by adding your first module.</p>
                <div>
                    <button type="button" class="btn primary d-inline-flex align-items-center gap-1"
                        @click="openAddModule()">
                        <i class="bi bi-plus-lg"></i> Add First Module
                    </button>
                </div>
            </div>
        @endforelse

        {{-- Module Add/Edit Modal --}}
        <div class="modal fade" id="moduleModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <form :action="moduleFormAction" method="POST" class="modal-content">
                    @csrf
                    <template x-if="isEditingModule">
                        <input type="hidden" name="_method" value="PUT">
                    </template>

                    <div class="modal-header">
                        <h5 class="modal-title" x-text="isEditingModule ? 'Edit Module' : 'Add New Module'"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label" for="module_title">Module Title <span
                                    class="text-danger">*</span></label>
                            <input type="text" id="module_title" name="title" x-model="moduleData.title"
                                class="form-control" placeholder="e.g. Module 01: PHP & OOP Basics" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="module_order">Display Order</label>
                            <input type="number" id="module_order" name="order" x-model="moduleData.order"
                                min="0" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="module_description">Short Description</label>
                            <textarea id="module_description" name="description" x-model="moduleData.description" rows="3"
                                class="form-control" placeholder="What topics does this module cover?"></textarea>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn primary"
                            x-text="isEditingModule ? 'Update Module' : 'Save Module'"></button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Lesson Add/Edit Modal --}}
        <div class="modal fade" id="lessonModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <form :action="lessonFormAction" method="POST" enctype="multipart/form-data" class="modal-content">
                    @csrf
                    <template x-if="isEditingLesson">
                        <input type="hidden" name="_method" value="PUT">
                    </template>

                    <div class="modal-header">
                        <div>
                            <h5 class="modal-title mb-0" x-text="isEditingLesson ? 'Edit Lesson' : 'Add New Lesson'"></h5>
                            <small class="text-muted" x-text="'Module: ' + activeModuleTitle"></small>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label class="form-label" for="lesson_title">Lesson Title <span
                                        class="text-danger">*</span></label>
                                <input type="text" id="lesson_title" name="title" x-model="lessonData.title"
                                    class="form-control" placeholder="e.g. Class 01: Laravel Routing & Controllers"
                                    required>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label" for="lesson_type">Lesson Type <span
                                        class="text-danger">*</span></label>
                                <select id="lesson_type" name="lesson_type" x-model="lessonData.lesson_type"
                                    class="form-select" required>
                                    @foreach ($lessonTypes as $type)
                                        <option value="{{ $type->value }}">{{ $type->label() }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label" for="lesson_order">Display Order</label>
                                <input type="number" id="lesson_order" name="order" x-model="lessonData.order"
                                    min="0" class="form-control">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label" for="duration_minutes">Duration (Minutes)</label>
                                <input type="number" id="duration_minutes" name="duration_minutes"
                                    x-model="lessonData.duration_minutes" min="1" class="form-control"
                                    placeholder="e.g. 90">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label" for="class_date_time">Class Date & Time</label>
                                <input type="datetime-local" id="class_date_time" name="class_date_time"
                                    x-model="lessonData.class_date_time" class="form-control">
                            </div>

                            <div class="col-md-12 mb-3" x-show="lessonData.lesson_type === 'online_class'">
                                <label class="form-label" for="meeting_link">Live Meeting Link (Zoom / Google
                                    Meet)</label>
                                <input type="url" id="meeting_link" name="meeting_link"
                                    x-model="lessonData.meeting_link" class="form-control"
                                    placeholder="https://meet.google.com/...">
                            </div>

                            <div class="col-md-4 mb-3"
                                x-show="lessonData.lesson_type === 'video' || lessonData.lesson_type === 'online_class' || lessonData.lesson_type === 'offline_class'">
                                <label class="form-label" for="video_provider">Recorded Video Source</label>
                                <select id="video_provider" name="video_provider" x-model="lessonData.video_provider"
                                    class="form-select">
                                    <option value="">None</option>
                                    <option value="youtube">YouTube (Unlisted)</option>
                                    <option value="vimeo">Vimeo</option>
                                    <option value="local">Local Server URL</option>
                                </select>
                            </div>

                            <div class="col-md-8 mb-3" x-show="lessonData.video_provider">
                                <label class="form-label" for="video_url">Video URL</label>
                                <input type="text" id="video_url" name="video_url" x-model="lessonData.video_url"
                                    class="form-control" placeholder="https://www.youtube.com/watch?v=...">
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label" for="attachment_file">Attachment / Notes / Assignment File <span
                                        class="text-muted">(PDF, DOC, ZIP, PPT — Max 10MB)</span></label>
                                <input type="file" id="attachment_file" name="attachment_file" class="form-control"
                                    accept=".pdf,.doc,.docx,.zip,.ppt,.pptx,.txt">
                                <template x-if="lessonData.attachment_file">
                                    <div class="form-text text-success">
                                        Current file uploaded. Upload a new file only if you want to replace it.
                                    </div>
                                </template>
                            </div>

                            <div class="col-12 mb-3">
                                <label class="form-label" for="lesson_notes">Class Notes / Assignment Instructions</label>
                                <textarea id="lesson_notes" name="notes" x-model="lessonData.notes" rows="3" class="form-control"
                                    placeholder="Write class summary, topics, or assignment instructions..."></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn primary"
                            x-text="isEditingLesson ? 'Update Lesson' : 'Save Lesson'"></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function curriculumBuilder() {
            return {
                isEditingModule: false,
                moduleFormAction: '',
                moduleData: {
                    title: '',
                    description: '',
                    order: 0
                },

                isEditingLesson: false,
                lessonFormAction: '',
                activeModuleTitle: '',
                lessonData: {
                    title: '',
                    lesson_type: 'offline_class',
                    order: 0,
                    duration_minutes: '',
                    class_date_time: '',
                    meeting_link: '',
                    video_provider: '',
                    video_url: '',
                    attachment_file: '',
                    notes: ''
                },

                openAddModule() {
                    this.isEditingModule = false;
                    this.moduleFormAction = "{{ route('admin.courses.modules.store', $course) }}";
                    this.moduleData = {
                        title: '',
                        description: '',
                        order: 0
                    };
                    new bootstrap.Modal(document.getElementById('moduleModal')).show();
                },

                openEditModule(mod) {
                    this.isEditingModule = true;
                    this.moduleFormAction = "{{ url('admin/courses/' . $course->id . '/modules') }}/" + mod.id;
                    this.moduleData = {
                        title: mod.title || '',
                        description: mod.description || '',
                        order: mod.order || 0
                    };
                    new bootstrap.Modal(document.getElementById('moduleModal')).show();
                },

                openAddLesson(moduleId, moduleTitle) {
                    this.isEditingLesson = false;
                    this.activeModuleTitle = moduleTitle;
                    this.lessonFormAction = "{{ url('admin/courses/' . $course->id . '/modules') }}/" + moduleId +
                        "/lessons";
                    this.lessonData = {
                        title: '',
                        lesson_type: 'offline_class',
                        order: 0,
                        duration_minutes: '',
                        class_date_time: '',
                        meeting_link: '',
                        video_provider: '',
                        video_url: '',
                        attachment_file: '',
                        notes: ''
                    };
                    new bootstrap.Modal(document.getElementById('lessonModal')).show();
                },

                openEditLesson(lesson, moduleTitle) {
                    this.isEditingLesson = true;
                    this.activeModuleTitle = moduleTitle;
                    this.lessonFormAction = "{{ url('admin/courses/' . $course->id . '/lessons') }}/" + lesson.id;
                    this.lessonData = {
                        title: lesson.title || '',
                        lesson_type: lesson.lesson_type || 'offline_class',
                        order: lesson.order || 0,
                        duration_minutes: lesson.duration_minutes || '',
                        class_date_time: lesson.class_date_time ? lesson.class_date_time.slice(0, 16) : '',
                        meeting_link: lesson.meeting_link || '',
                        video_provider: lesson.video_provider || '',
                        video_url: lesson.video_url || '',
                        attachment_file: lesson.attachment_file || '',
                        notes: lesson.notes || ''
                    };
                    new bootstrap.Modal(document.getElementById('lessonModal')).show();
                }
            }
        }
    </script>
@endpush
