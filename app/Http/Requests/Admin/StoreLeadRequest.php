<?php

namespace App\Http\Requests\Admin;

use App\Enums\LeadSource;
use App\Enums\LeadStatus;
use App\Enums\LeadType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class StoreLeadRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('create-leads');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'company_name' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'website' => ['nullable', 'string', 'max:255'],
            'industry_id' => ['nullable', 'integer', 'exists:industries,id'],
            'assigned_to' => ['nullable', 'integer', 'exists:users,id'],
            'currency_id' => ['nullable', 'integer', 'exists:currencies,id'],
            'lead_source' => ['nullable', 'string', Rule::enum(LeadSource::class)],
            'lead_type' => ['nullable', 'string', Rule::enum(LeadType::class)],
            'budget' => ['nullable', 'numeric', 'min:0'],
            'status' => ['required', 'string', Rule::enum(LeadStatus::class)],
            'message' => ['nullable', 'string'],
            'service_ids' => ['nullable', 'array'],
            'service_ids.*' => ['integer', 'exists:services,id'],
            'utm_source' => ['nullable', 'string', 'max:255'],
            'utm_medium' => ['nullable', 'string', 'max:255'],
            'utm_campaign' => ['nullable', 'string', 'max:255'],
            'utm_content' => ['nullable', 'string', 'max:255'],
        ];
    }
}
