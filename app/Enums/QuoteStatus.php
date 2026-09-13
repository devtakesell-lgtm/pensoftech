<?php

namespace App\Enums;

enum QuoteStatus: string
{
    case Draft = 'draft';
    case Sent = 'sent';
    case Accepted = 'accepted';
    case Rejected = 'rejected';
    case Expired = 'expired';

    public function label(): string
    {
        return match ($this) {
            self::Draft => 'Draft',
            self::Sent => 'Sent',
            self::Accepted => 'Accepted',
            self::Rejected => 'Rejected',
            self::Expired => 'Expired',
        };
    }

    public function badgeClass(): string
    {
        return match ($this) {
            self::Draft => 'quote-status-draft',
            self::Sent => 'quote-status-sent',
            self::Accepted => 'quote-status-accepted',
            self::Rejected => 'quote-status-rejected',
            self::Expired => 'quote-status-expired',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::Draft => 'bi-file-earmark',
            self::Sent => 'bi-send',
            self::Accepted => 'bi-check-circle-fill',
            self::Rejected => 'bi-x-circle-fill',
            self::Expired => 'bi-clock-history',
        };
    }

    public static function options(): array
    {
        return array_map(fn ($case) => ['value' => $case->value, 'label' => $case->label()], self::cases());
    }
}
