<?php

namespace App\Models;

use App\Enums\LessonType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CourseLesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_module_id',
        'title',
        'lesson_type',
        'duration_minutes',
        'class_date_time',
        'meeting_link',
        'video_provider',
        'video_url',
        'attachment_file',
        'notes',
        'order',
    ];

    /** @var array<string, string|class-string> */
    protected $casts = [
        'lesson_type' => LessonType::class,
        'class_date_time' => 'datetime',
        'order' => 'integer',
        'duration_minutes' => 'integer',
    ];

    public function module(): BelongsTo
    {
        return $this->belongsTo(CourseModule::class, 'course_module_id');
    }
}
