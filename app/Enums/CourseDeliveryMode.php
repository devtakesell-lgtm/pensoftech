<?php

namespace App\Enums;

enum CourseDeliveryMode: string
{
    case Offline = 'offline';
    case Online = 'online';
    case Hybrid = 'hybrid';

    public function label(): string
    {
        return match ($this) {
            self::Offline => 'In-Person (Office)',
            self::Online => 'Online (Live)',
            self::Hybrid => 'Hybrid',
        };
    }

    public function badgeClass(): string
    {
        return match ($this) {
            self::Offline => 'badge bg-primary-subtle text-primary border border-primary-subtle',
            self::Online => 'badge bg-info-subtle text-info border border-info-subtle',
            self::Hybrid => 'badge bg-warning-subtle text-warning border border-warning-subtle',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::Offline => 'bi-building',
            self::Online => 'bi-camera-video',
            self::Hybrid => 'bi-laptop',
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
