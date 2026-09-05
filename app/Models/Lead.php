<?php

namespace App\Models;

use App\Enums\LeadStatus;
use Database\Factories\LeadFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lead extends Model
{
    /** @use HasFactory<LeadFactory> */
    use HasFactory;

    protected $fillable = [
        'client_id',
        'industry_id',
        'assigned_to',
        'currency_id',
        'lead_source',
        'lead_type',
        'name',
        'company_name',
        'email',
        'phone',
        'website',
        'message',
        'budget',
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
}
