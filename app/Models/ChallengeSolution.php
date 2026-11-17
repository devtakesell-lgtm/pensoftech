<?php

namespace App\Models;

use App\Enums\SolutionStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChallengeSolution extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'case_study_challenge_id',
        'description',
        'status',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'status' => SolutionStatus::class,
        ];
    }

    /**
     * Get the challenge that owns the solution.
     */
    public function challenge(): BelongsTo
    {
        return $this->belongsTo(CaseStudyChallenge::class, 'case_study_challenge_id');
    }
}
