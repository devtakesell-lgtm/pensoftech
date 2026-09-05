<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CaseStudyMetric extends Model
{
    /** @use HasFactory<\Database\Factories\CaseStudyMetricFactory> */
    use HasFactory;

    protected $fillable = [
        'case_study_id',
        'metric_name',
        'metric_value',
        'metric_suffix',
        'sort_order',
    ];

    public function caseStudy(): BelongsTo
    {
        return $this->belongsTo(CaseStudy::class);
    }
}
