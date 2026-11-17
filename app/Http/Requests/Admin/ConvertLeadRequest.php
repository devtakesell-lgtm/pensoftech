<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class ConvertLeadRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Gate::allows('edit-leads');
    }

    protected function prepareForValidation()
    {
        if ($this->website && ! preg_match('~^(?:f|ht)tps?://~i', $this->website)) {
            $this->merge([
                'website' => 'https://'.$this->website,
            ]);
        }
    }

    public function rules(): array
    {
        return [
            'contact_person' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'company_name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'website' => ['nullable', 'url', 'max:255'],
        ];
    }
}
