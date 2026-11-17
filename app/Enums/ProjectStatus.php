<?php

namespace App\Enums;

enum ProjectStatus: string
{
    case Upcoming = 'upcoming';
    case Ongoing = 'ongoing';
    case Completed = 'completed';
    case OnHold = 'on_hold';

    public function label(): string
    {
        return match ($this) {
            self::Upcoming => 'Upcoming',
            self::Ongoing => 'Ongoing',
            self::Completed => 'Completed',
            self::OnHold => 'On Hold',
        };
    }

    public function badgeClass(): string
    {
        return match ($this) {
            self::Upcoming => 'status-badge-new',
            self::Ongoing => 'status-badge-progress',
            self::Completed => 'status-badge-won',
            self::OnHold => 'status-badge-lost',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::Upcoming => 'bi-calendar-event',
            self::Ongoing => 'bi-arrow-repeat',
            self::Completed => 'bi-check2-circle',
            self::OnHold => 'bi-pause-circle',
        };
    }

    public static function options(): array
    {
        return array_map(fn ($case) => ['value' => $case->value, 'label' => $case->label()], self::cases());
    }
}
