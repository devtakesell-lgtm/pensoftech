<?php

namespace App\Models;

use App\Enums\CouponDiscountType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'code',
        'discount_type',
        'discount_value',
        'min_spend',
        'max_discount',
        'usage_limit',
        'used_count',
        'start_date',
        'expires_at',
        'is_active',
    ];

    /** @var array<string, string|class-string> */
    protected $casts = [
        'discount_type' => CouponDiscountType::class,
        'discount_value' => 'decimal:2',
        'min_spend' => 'decimal:2',
        'max_discount' => 'decimal:2',
        'usage_limit' => 'integer',
        'used_count' => 'integer',
        'start_date' => 'datetime',
        'expires_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('start_date')->orWhere('start_date', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('expires_at')->orWhere('expires_at', '>=', now());
            });
    }

    public function isValidFor(Course $course, float $amount): bool
    {
        if (! $this->is_active) {
            return false;
        }

        if ($this->course_id && $this->course_id !== $course->id) {
            return false;
        }

        if ($this->start_date && $this->start_date > now()) {
            return false;
        }

        if ($this->expires_at && $this->expires_at < now()) {
            return false;
        }

        if ($this->usage_limit && $this->used_count >= $this->usage_limit) {
            return false;
        }

        if ($this->min_spend && $amount < (float) $this->min_spend) {
            return false;
        }

        return true;
    }

    public function calculateDiscount(float $amount): float
    {
        if ($this->discount_type === CouponDiscountType::Percentage) {
            $discount = ($amount * (float) $this->discount_value) / 100.0;
            if ($this->max_discount && $discount > (float) $this->max_discount) {
                return (float) $this->max_discount;
            }

            return round($discount, 2);
        }

        return min($amount, (float) $this->discount_value);
    }
}
