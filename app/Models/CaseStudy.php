<?php

namespace App\Models;

use App\Enums\ContentStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class CaseStudy extends Model
{
    /** @use HasFactory<\Database\Factories\CaseStudyFactory> */
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'project_id',
        'client_id',
        'title',
        'slug',
        'challenge',
        'solution',
        'result',
        'content',
        'featured_image',
        'status',
        'published_at',
    ];

    protected $casts = [
        'status' => ContentStatus::class,
        'published_at' => 'datetime',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function metrics(): HasMany
    {
        return $this->hasMany(CaseStudyMetric::class);
    }

    public function seo(): MorphOne
    {
        return $this->morphOne(SeoMeta::class, 'seoable');
    }
}
