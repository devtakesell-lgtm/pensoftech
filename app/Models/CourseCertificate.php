<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CourseCertificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'course_application_id',
        'user_id',
        'certificate_number',
        'student_name',
        'issue_date',
        'verification_token',
        'file_path',
        'status',
    ];

    /** @var array<string, string> */
    protected $casts = [
        'issue_date' => 'date',
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function application(): BelongsTo
    {
        return $this->belongsTo(CourseApplication::class, 'course_application_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
