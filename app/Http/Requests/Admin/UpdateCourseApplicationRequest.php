<?php

namespace App\Http\Requests\Admin;

use App\Enums\CourseApplicationStatus;
use App\Enums\CoursePaymentStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdateCourseApplicationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Gate::allows('edit-course-applications');
    }

    /**
     * @return array<string, array<mixed>>
     */
    public function rules(): array
    {
        return [
            'status' => ['required', 'string', Rule::enum(CourseApplicationStatus::class)],
            'payment_status' => ['required', 'string', Rule::enum(CoursePaymentStatus::class)],
            'interview_date' => ['nullable', 'date'],
            'interview_time' => ['nullable', 'string', 'max:20'],
            'interview_venue' => ['nullable', 'string', 'max:255'],
            'interview_notes' => ['nullable', 'string'],
            'admin_notes' => ['nullable', 'string'],
        ];
    }
}
