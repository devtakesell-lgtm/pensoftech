<?php

namespace App\Enums;

enum EnrollmentStatus: string
{
    case Active = 'active';
    case Completed = 'completed';
    case Dropped = 'dropped';
    case Suspended = 'suspended';

    public function label(): string
    {
        return match ($this) {
            self::Active => 'Active',
            self::Completed => 'Completed',
            self::Dropped => 'Dropped',
            self::Suspended => 'Suspended',
        };
    }

    public function badgeClass(): string
    {
        return match ($this) {
            self::Active => 'badge bg-success-subtle text-success border border-success-subtle',
            self::Completed => 'badge bg-primary-subtle text-primary border border-primary-subtle',
            self::Dropped => 'badge bg-danger-subtle text-danger border border-danger-subtle',
            self::Suspended => 'badge bg-warning-subtle text-warning border border-warning-subtle',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::Active => 'bi-play-circle',
            self::Completed => 'bi-award',
            self::Dropped => 'bi-x-circle',
            self::Suspended => 'bi-pause-circle',
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
