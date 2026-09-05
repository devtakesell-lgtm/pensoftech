<?php

namespace App\Models;

use App\Enums\EmploymentType;
use App\Enums\JobStatus;
use Database\Factories\JobFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Job extends Model
{
    /** @use HasFactory<JobFactory> */
    use HasFactory;

    protected $table = 'jobs_listings';

    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'employment_type',
        'location',
        'experience',
        'vacancy',
        'description',
        'requirements',
        'benefits',
        'deadline',
        'status',
    ];

    /** @var array<string, string|class-string> */
    protected $casts = [
        'status' => JobStatus::class,
        'employment_type' => EmploymentType::class,
        'deadline' => 'date',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(JobCategory::class, 'category_id');
    }

    public function applications(): HasMany
    {
        return $this->hasMany(JobApplication::class);
    }

    public function seo(): MorphOne
    {
        return $this->morphOne(SeoMeta::class, 'seoable');
    }
}
