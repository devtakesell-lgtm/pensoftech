<?php

namespace App\Models;

use App\Enums\QuoteStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quote extends Model
{
    /** @use HasFactory<\Database\Factories\QuoteFactory> */
    use HasFactory;

    use SoftDeletes;

    protected $fillable = [
        'lead_id',
        'currency_id',
        'quote_number',
        'title',
        'description',
        'budget_min',
        'budget_max',
        'status',
        'valid_until',
        'created_by',
    ];

    protected $casts = [
        'status' => QuoteStatus::class,
        'budget_min' => 'decimal:2',
        'budget_max' => 'decimal:2',
        'valid_until' => 'date',
    ];

    public function lead(): BelongsTo
    {
        return $this->belongsTo(Lead::class);
    }

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function services(): HasMany
    {
        return $this->hasMany(QuoteService::class);
    }
}
