<?php

namespace App\Http\Requests\Admin;

use App\Enums\ContentStatus;
use App\Enums\SolutionStatus;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdateCaseStudyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('edit-case-studies');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'project_id' => ['required', 'exists:projects,id'],
            'title' => ['required', 'string', 'max:255'],
            'challenges' => ['nullable', 'array'],
            'challenges.*.title' => ['required_with:challenges', 'string', 'max:255'],
            'challenges.*.description' => ['nullable', 'string'],
            'challenges.*.solutions' => ['nullable', 'array'],
            'challenges.*.solutions.*.description' => ['required_with:challenges.*.solutions', 'string'],
            'challenges.*.solutions.*.status' => ['nullable', Rule::enum(SolutionStatus::class)],

            'result' => ['required', 'string'],
            'content' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,webp,jpg', 'max:2048'],
            'status' => ['required', Rule::enum(ContentStatus::class)],
            'published_at' => ['nullable', 'date'],

            'metrics' => ['nullable', 'array'],
            'metrics.*.metric_name' => ['required_with:metrics', 'string', 'max:255'],
            'metrics.*.metric_value' => ['required_with:metrics', 'string', 'max:255'],
            'metrics.*.metric_suffix' => ['nullable', 'string', 'max:50'],
        ];
    }
}
