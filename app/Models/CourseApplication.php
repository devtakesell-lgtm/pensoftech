<?php

namespace App\Models;

use App\Enums\CourseApplicationStatus;
use App\Enums\CoursePaymentStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class CourseApplication extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'course_id',
        'user_id',
        'coupon_id',
        'currency_id',
        'application_no',
        'student_name',
        'email',
        'phone',
        'alt_phone',
        'gender',
        'present_address',
        'educational_qualification',
        'current_profession',
        'experience_level',
        'why_this_course',
        'portfolio_or_github',
        'course_fee',
        'discount_amount',
        'payable_amount',
        'payment_method',
        'transaction_id',
        'sender_phone_number',
        'payment_status',
        'status',
        'interview_date',
        'interview_time',
        'interview_venue',
        'interview_notes',
        'admin_notes',
    ];

    /** @var array<string, string|class-string> */
    protected $casts = [
        'payment_status' => CoursePaymentStatus::class,
        'status' => CourseApplicationStatus::class,
        'interview_date' => 'date',
        'course_fee' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'payable_amount' => 'decimal:2',
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function coupon(): BelongsTo
    {
        return $this->belongsTo(Coupon::class);
    }

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }

    public function certificate(): HasOne
    {
        return $this->hasOne(CourseCertificate::class);
    }

    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', CourseApplicationStatus::Pending);
    }

    public function scopeShortlisted(Builder $query): Builder
    {
        return $query->where('status', CourseApplicationStatus::Shortlisted);
    }

    public function scopeInterviewScheduled(Builder $query): Builder
    {
        return $query->where('status', CourseApplicationStatus::InterviewScheduled);
    }

    public function scopeSelected(Builder $query): Builder
    {
        return $query->where('status', CourseApplicationStatus::Selected);
    }

    public function scopeEnrolled(Builder $query): Builder
    {
        return $query->where('status', CourseApplicationStatus::Enrolled);
    }
}
