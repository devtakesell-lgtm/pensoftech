<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class StoreCourseCategoryRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:course_categories,slug'],
            'icon' => ['nullable', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'is_active' => ['boolean'],
            'order' => ['nullable', 'integer', 'min:0'],
        ];
    }

    protected function prepareForValidation(): void
    {
        if (empty($this->slug) && ! empty($this->name)) {
            $this->merge([
                'slug' => Str::slug($this->name),
            ]);
        }

        $this->merge([
            'is_active' => $this->boolean('is_active', true),
        ]);
    }
}
