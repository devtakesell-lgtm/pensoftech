<?php

namespace App\Models;

use App\Enums\ProjectStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    /** @use HasFactory<\Database\Factories\ProjectFactory> */
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'client_id',
        'industry_id',
        'title',
        'slug',
        'short_description',
        'description',
        'project_url',
        'featured_image',
        'start_date',
        'completion_date',
        'status',
        'is_featured',
        'sort_order',
    ];

    protected $casts = [
        'status' => ProjectStatus::class,
        'is_featured' => 'boolean',
        'start_date' => 'date',
        'completion_date' => 'date',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function industry(): BelongsTo
    {
        return $this->belongsTo(Industry::class);
    }

    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class, 'project_service');
    }

    public function caseStudies(): HasMany
    {
        return $this->hasMany(CaseStudy::class);
    }

    public function seo(): MorphOne
    {
        return $this->morphOne(SeoMeta::class, 'seoable');
    }
}
