<?php

namespace App\Enums;

enum CoursePaymentStatus: string
{
    case WaivedForFree = 'waived_for_free';
    case Pending = 'pending';
    case Verified = 'verified';
    case Refunded = 'refunded';

    public function label(): string
    {
        return match ($this) {
            self::WaivedForFree => 'Waived (Free Course)',
            self::Pending => 'Pending Verification',
            self::Verified => 'Payment Verified',
            self::Refunded => 'Refunded',
        };
    }

    public function badgeClass(): string
    {
        return match ($this) {
            self::WaivedForFree => 'badge bg-info-subtle text-info border border-info-subtle',
            self::Pending => 'badge bg-warning-subtle text-warning border border-warning-subtle',
            self::Verified => 'badge bg-success-subtle text-success border border-success-subtle',
            self::Refunded => 'badge bg-secondary-subtle text-secondary border border-secondary-subtle',
        };
    }

    /**
     * @return array<int, array{value: string, label: string}>
     */
    public static function options(): array
    {
        return array_map(fn ($case) => ['value' => $case->value, 'label' => $case->label()], self::cases());
    }
}
