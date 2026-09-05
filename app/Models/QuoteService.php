<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuoteService extends Model
{
    /** @use HasFactory<\Database\Factories\QuoteServiceFactory> */
    use HasFactory;

    protected $fillable = [
        'quote_id',
        'service_id',
        'quantity',
        'unit_price',
        'total_price',
        'description',
    ];

    protected $casts = [
        'unit_price' => 'decimal:2',
        'total_price' => 'decimal:2',
    ];

    public function quote(): BelongsTo
    {
        return $this->belongsTo(Quote::class);
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }
}
