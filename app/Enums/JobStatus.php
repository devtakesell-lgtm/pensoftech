<?php

namespace App\Enums;

enum JobStatus: string
{
    case Draft = 'draft';
    case Open = 'open';
    case Closed = 'closed';

    public function label(): string
    {
        return match ($this) {
            self::Draft => 'Draft',
            self::Open => 'Open',
            self::Closed => 'Closed',
        };
    }

    public function badgeClass(): string
    {
        return match ($this) {
            self::Open => 'category-status-active',
            self::Draft => 'category-status-inactive',
            self::Closed => 'category-status-closed',
        };
    }

    public function classBadge(): string
    {
        return $this->badgeClass();
    }

    public function classBaged(): string
    {
        return $this->badgeClass();
    }

    public function icon(): string
    {
        return match ($this) {
            self::Open => 'bi-check2-circle',
            self::Draft => 'bi-pencil-square',
            self::Closed => 'bi-x-circle',
        };
    }

    public static function options(): array
    {
        return array_map(fn ($case) => ['value' => $case->value, 'label' => $case->label()], self::cases());
    }
}
