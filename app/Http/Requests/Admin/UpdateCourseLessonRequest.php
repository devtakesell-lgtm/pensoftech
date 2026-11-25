<?php

namespace App\Http\Requests\Admin;

use App\Enums\LessonType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdateCourseLessonRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Gate::allows('edit-courses');
    }

    /**
     * @return array<string, array<mixed>>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'lesson_type' => ['required', 'string', Rule::enum(LessonType::class)],
            'duration_minutes' => ['nullable', 'integer', 'min:1'],
            'class_date_time' => ['nullable', 'date'],
            'meeting_link' => ['nullable', 'url', 'max:500'],
            'video_provider' => ['nullable', 'string', Rule::in(['youtube', 'vimeo', 'local'])],
            'video_url' => ['nullable', 'string', 'max:500'],
            'attachment_file' => ['nullable', 'file', 'mimes:pdf,doc,docx,zip,ppt,pptx,txt', 'max:10240'],
            'notes' => ['nullable', 'string'],
            'order' => ['nullable', 'integer', 'min:0'],
        ];
    }

    protected function prepareForValidation(): void
    {
        if ($this->input('order') === null || $this->input('order') === '') {
            $this->merge(['order' => 0]);
        }
    }
}
