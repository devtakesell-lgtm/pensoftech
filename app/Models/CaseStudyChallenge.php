<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CaseStudyChallenge extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'case_study_id',
        'title',
        'description',
    ];

    /**
     * Get the case study that owns the challenge.
     */
    public function caseStudy(): BelongsTo
    {
        return $this->belongsTo(CaseStudy::class);
    }

    /**
     * Get the solutions for the challenge.
     */
    public function solutions(): HasMany
    {
        return $this->hasMany(ChallengeSolution::class);
    }
}
