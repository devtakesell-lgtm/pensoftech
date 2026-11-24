<?php

namespace App\Enums;

enum LessonType: string
{
    case OfflineClass = 'offline_class';
    case OnlineClass = 'online_class';
    case Video = 'video';
    case Notes = 'notes';
    case Assignment = 'assignment';

    public function label(): string
    {
        return match ($this) {
            self::OfflineClass => 'Offline (Office Class)',
            self::OnlineClass => 'Online Live Class',
            self::Video => 'Video Lecture',
            self::Notes => 'Reading Material / Notes',
            self::Assignment => 'Assignment / Project',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::OfflineClass => 'bi-building',
            self::OnlineClass => 'bi-camera-video',
            self::Video => 'bi-play-circle',
            self::Notes => 'bi-file-earmark-text',
            self::Assignment => 'bi-clipboard-check',
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
