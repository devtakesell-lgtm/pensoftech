<?php

namespace App\Http\Requests\Admin;

use App\Enums\EmploymentType;
use App\Enums\JobStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class StoreJobRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Gate::allows('create-jobs');
    }

    public function rules(): array
    {
        return [
            'job_category_id' => ['nullable', 'exists:job_categories,id'],
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:jobs_listings,slug'],
            'employment_type' => ['nullable', 'string', Rule::enum(EmploymentType::class)],
            'location' => ['nullable', 'string', 'max:255'],
            'experience' => ['nullable', 'string', 'max:255'],
            'vacancy' => ['nullable', 'integer', 'min:1'],
            'description' => ['required', 'string'],
            'requirements' => ['nullable', 'string'],
            'benefits' => ['nullable', 'string'],
            'deadline' => ['nullable', 'date'],
            'status' => ['required', 'string', Rule::enum(JobStatus::class)],
        ];
    }
    
    public function prepareForValidation()
    {
        if (empty($this->slug) && !empty($this->title)) {
            $this->merge([
                'slug' => \Str::slug($this->title)
            ]);
        }
    }
}
