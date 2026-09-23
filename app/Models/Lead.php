<?php

namespace App\Models;

use App\Enums\LeadStatus;
use Database\Factories\LeadFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lead extends Model
{
    /** @use HasFactory<LeadFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'client_id',
        'industry_id',
        'assigned_to',
        'currency_id',
        'lead_source',
        'lead_type',
        'name',
        'job_title',
        'company_name',
        'email',
        'phone',
        'website',
        'message',
        'budget',
        'timeline',
        'attachment_path',
        'status',
        'utm_source',
        'utm_medium',
        'utm_campaign',
        'utm_content',
        'gclid',
        'fbclid',
        'ip_address',
    ];

    protected $casts = [
        'status' => LeadStatus::class,
        'budget' => 'decimal:2',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function industry(): BelongsTo
    {
        return $this->belongsTo(Industry::class);
    }

    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }

    // A lead can be interested in multiple services.
    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class, 'lead_service')->withTimestamps();
    }

    public function quotes(): HasMany
    {
        return $this->hasMany(Quote::class);
    }

    /**
     * Determine if the lead has been converted into an official client account.
     */
    public function isConvertedClient(): bool
    {
        return ! is_null($this->client_id);
    }

    /**
     * Filter leads query by search keyword, status, source, industry, or assignee.
     *
     * @param  array<string, mixed>  $filters
     */
    public function scopeFilter(Builder $query, array $filters): Builder
    {
        return $query
            ->when($filters['search'] ?? null, function (Builder $q, $search) {
                $q->where(function (Builder $sub) use ($search) {
                    $sub->where('name', 'like', "%{$search}%")
                        ->orWhere('company_name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%");
                });
            })
            ->when($filters['status'] ?? null, function (Builder $q, $status) {
                $q->where('status', $status);
            })
            ->when($filters['source'] ?? null, function (Builder $q, $source) {
                $q->where('lead_source', $source);
            })
            ->when($filters['industry_id'] ?? null, function (Builder $q, $industryId) {
                $q->where('industry_id', $industryId);
            })
            ->when($filters['assigned_to'] ?? null, function (Builder $q, $userId) {
                $q->where('assigned_to', $userId);
            });
    }

    /**
     * Get the country name from the IP address using ip-api.com
     */
    public function getCountryFromIpAttribute(): ?string
    {
        if (!$this->ip_address || $this->ip_address === '127.0.0.1' || $this->ip_address === '::1') {
            return 'Localhost';
        }

        return cache()->remember('ip_country_' . $this->ip_address, now()->addDays(30), function () {
            try {
                $response = \Illuminate\Support\Facades\Http::timeout(3)->get("http://ip-api.com/json/{$this->ip_address}");
                if ($response->successful() && $response->json('status') === 'success') {
                    return $response->json('country');
                }
            } catch (\Exception $e) {
                // Return null if API fails
            }
            return null;
        });
    }
}
