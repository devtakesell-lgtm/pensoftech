<?php

namespace App\Http\Requests\Admin;

use App\Enums\CourseDeliveryMode;
use App\Enums\CourseStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class StoreCourseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Gate::allows('create-courses');
    }

    /**
     * @return array<string, array<mixed>>
     */
    public function rules(): array
    {
        return [
            'course_category_id' => ['required', 'exists:course_categories,id'],
            'instructor_id' => ['nullable', 'exists:instructors,id'],
            'currency_id' => ['nullable', 'exists:currencies,id'],
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:courses,slug'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'thumbnail' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:2048'],
            'banner' => ['nullable', 'string', 'max:500'],
            'delivery_mode' => ['required', 'string', Rule::enum(CourseDeliveryMode::class)],
            'venue' => ['nullable', 'string', 'max:255'],
            'batch_no' => ['nullable', 'string', 'max:100'],
            'class_schedule' => ['nullable', 'string', 'max:255'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'enrollment_deadline' => ['nullable', 'date'],
            'total_classes' => ['nullable', 'integer', 'min:1'],
            'duration_weeks' => ['nullable', 'integer', 'min:1'],
            'max_seats' => ['nullable', 'integer', 'min:1'],
            'is_free' => ['boolean'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'discount_price' => ['nullable', 'numeric', 'min:0'],
            'prerequisites' => ['nullable', 'array'],
            'prerequisites.*' => ['nullable', 'string', 'max:255'],
            'what_you_will_learn' => ['nullable', 'array'],
            'what_you_will_learn.*' => ['nullable', 'string', 'max:255'],
            'intro_video_url' => ['nullable', 'url', 'max:255'],
            'status' => ['required', 'string', Rule::enum(CourseStatus::class)],
            'is_featured' => ['boolean'],
        ];
    }

    protected function prepareForValidation(): void
    {
        if (empty($this->slug) && ! empty($this->title)) {
            $this->merge([
                'slug' => Str::slug($this->title),
            ]);
        }

        $this->merge([
            'is_free' => $this->boolean('is_free'),
            'is_featured' => $this->boolean('is_featured'),
        ]);
    }
}
