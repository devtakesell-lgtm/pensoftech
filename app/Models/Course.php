<?php

namespace App\Models;

use App\Enums\CourseDeliveryMode;
use App\Enums\CourseStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'course_category_id',
        'instructor_id',
        'currency_id',
        'title',
        'slug',
        'subtitle',
        'description',
        'thumbnail',
        'banner',
        'delivery_mode',
        'venue',
        'batch_no',
        'class_schedule',
        'start_date',
        'end_date',
        'enrollment_deadline',
        'total_classes',
        'duration_weeks',
        'max_seats',
        'is_free',
        'price',
        'discount_price',
        'prerequisites',
        'what_you_will_learn',
        'intro_video_url',
        'status',
        'is_featured',
    ];

    /** @var array<string, string|class-string> */
    protected $casts = [
        'delivery_mode' => CourseDeliveryMode::class,
        'status' => CourseStatus::class,
        'start_date' => 'date',
        'end_date' => 'date',
        'enrollment_deadline' => 'date',
        'is_free' => 'boolean',
        'is_featured' => 'boolean',
        'price' => 'decimal:2',
        'discount_price' => 'decimal:2',
        'prerequisites' => 'array',
        'what_you_will_learn' => 'array',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(CourseCategory::class, 'course_category_id');
    }

    public function instructor(): BelongsTo
    {
        return $this->belongsTo(Instructor::class, 'instructor_id');
    }

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }

    public function modules(): HasMany
    {
        return $this->hasMany(CourseModule::class)->orderBy('order');
    }

    public function applications(): HasMany
    {
        return $this->hasMany(CourseApplication::class);
    }

    public function coupons(): HasMany
    {
        return $this->hasMany(Coupon::class);
    }

    public function certificates(): HasMany
    {
        return $this->hasMany(CourseCertificate::class);
    }

    public function seo(): MorphOne
    {
        return $this->morphOne(SeoMeta::class, 'seoable');
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', CourseStatus::Published);
    }

    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    public function effectivePrice(): float
    {
        if ($this->is_free) {
            return 0.0;
        }

        return (float) ($this->discount_price ?? $this->price ?? 0.0);
    }
}
