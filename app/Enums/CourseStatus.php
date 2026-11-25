<?php

namespace App\Enums;

enum CourseStatus: string
{
    case Draft = 'draft';
    case Published = 'published';
    case Archived = 'archived';

    public function label(): string
    {
        return match ($this) {
            self::Draft => 'Draft',
            self::Published => 'Published',
            self::Archived => 'Archived',
        };
    }

    public function badgeClass(): string
    {
        return match ($this) {
            self::Draft => 'badge bg-secondary-subtle text-secondary border border-secondary-subtle',
            self::Published => 'badge bg-success-subtle text-success border border-success-subtle',
            self::Archived => 'badge bg-dark-subtle text-dark border border-dark-subtle',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::Draft => 'bi-pencil-square',
            self::Published => 'bi-check2-circle',
            self::Archived => 'bi-archive',
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
