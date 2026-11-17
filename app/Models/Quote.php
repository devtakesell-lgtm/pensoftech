<?php

namespace App\Models;

use App\Enums\QuoteStatus;
use Database\Factories\QuoteFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quote extends Model
{
    /** @use HasFactory<QuoteFactory> */
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

    /**
     * Filter quotes query by search keyword, status, or lead.
     *
     * @param  array<string, mixed>  $filters
     */
    public function scopeFilter(Builder $query, array $filters): Builder
    {
        return $query
            ->when($filters['search'] ?? null, function (Builder $q, $search) {
                $q->where(function (Builder $sub) use ($search) {
                    $sub->where('quote_number', 'like', "%{$search}%")
                        ->orWhere('title', 'like', "%{$search}%")
                        ->orWhereHas('lead', function (Builder $leadQuery) use ($search) {
                            $leadQuery->where('name', 'like', "%{$search}%")
                                ->orWhere('company_name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
                        });
                });
            })
            ->when($filters['status'] ?? null, function (Builder $q, $status) {
                $q->where('status', $status);
            })
            ->when($filters['lead_id'] ?? null, function (Builder $q, $leadId) {
                $q->where('lead_id', $leadId);
            });
    }
}
