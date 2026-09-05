<?php

namespace App\Models;

use App\Enums\CareerStatus;
use App\Enums\EmploymentType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Career extends Model
{
    /** @use HasFactory<\Database\Factories\CareerFactory> */
    use HasFactory;

    protected $fillable = [
        'career_category_id',
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

    protected $casts = [
        'status' => CareerStatus::class,
        'employment_type' => EmploymentType::class,
        'deadline' => 'date',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(CareerCategory::class, 'career_category_id');
    }

    public function applications(): HasMany
    {
        return $this->hasMany(CareerApplication::class);
    }

    public function seo(): MorphOne
    {
        return $this->morphOne(SeoMeta::class, 'seoable');
    }
}
