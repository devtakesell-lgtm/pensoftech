<?php

namespace App\Http\Requests\Admin;

use App\Enums\QuoteStatus;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreQuoteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return \Illuminate\Support\Facades\Gate::allows('create-quotes');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'lead_id' => ['required', 'exists:leads,id'],
            'currency_id' => ['required', 'exists:currencies,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'budget_min' => ['nullable', 'numeric', 'min:0'],
            'budget_max' => ['nullable', 'numeric', 'min:0', 'gte:budget_min'],
            'status' => ['required', 'string', \Illuminate\Validation\Rule::in([QuoteStatus::Draft->value, QuoteStatus::Sent->value])],
            'valid_until' => ['nullable', 'date'],
        ];
    }
}
