<?php

namespace App\Http\Requests\Frontend;

use App\Models\Course;
use Illuminate\Foundation\Http\FormRequest;

class StoreCourseApplicationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, array<mixed>>
     */
    public function rules(): array
    {
        $slug = $this->route('slug');
        $course = Course::published()->where('slug', $slug)->first();
        $isPaid = $course && ! $course->is_free && $course->effectivePrice() > 0;

        return [
            'student_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:30'],
            'alt_phone' => ['nullable', 'string', 'max:30'],
            'gender' => ['nullable', 'string', 'in:Male,Female,Other'],
            'present_address' => ['required', 'string', 'max:500'],
            'educational_qualification' => ['required', 'string', 'max:255'],
            'current_profession' => ['required', 'string', 'max:255'],
            'experience_level' => ['required', 'string', 'in:Beginner,Intermediate,Advanced'],
            'why_this_course' => ['required', 'string', 'min:20', 'max:2000'],
            'portfolio_or_github' => ['nullable', 'url', 'max:255'],
            'coupon_code' => ['nullable', 'string', 'max:50'],
            'payment_method' => [$isPaid ? 'required' : 'nullable', 'string', 'in:bkash,nagad,rocket,bank,manual,free'],
            'transaction_id' => [$isPaid ? 'required' : 'nullable', 'string', 'max:100'],
            'sender_phone_number' => [$isPaid ? 'required' : 'nullable', 'string', 'max:30'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'why_this_course.min' => 'Please write at least 20 characters explaining why you want to join this course.',
            'transaction_id.required' => 'Please provide your payment Transaction ID (TrxID).',
            'sender_phone_number.required' => 'Please provide the phone number used to send the payment.',
        ];
    }
}
