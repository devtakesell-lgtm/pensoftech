<?php

namespace App\Enums;

enum CourseApplicationStatus: string
{
    case Pending = 'pending';
    case Shortlisted = 'shortlisted';
    case InterviewScheduled = 'interview_scheduled';
    case Selected = 'selected';
    case Enrolled = 'enrolled';
    case Rejected = 'rejected';

    public function label(): string
    {
        return match ($this) {
            self::Pending => 'Pending Review',
            self::Shortlisted => 'Shortlisted',
            self::InterviewScheduled => 'Interview Scheduled',
            self::Selected => 'Selected',
            self::Enrolled => 'Enrolled',
            self::Rejected => 'Rejected',
        };
    }

    public function badgeClass(): string
    {
        return match ($this) {
            self::Pending => 'badge bg-warning-subtle text-warning border border-warning-subtle',
            self::Shortlisted => 'badge bg-info-subtle text-info border border-info-subtle',
            self::InterviewScheduled => 'badge bg-primary-subtle text-primary border border-primary-subtle',
            self::Selected => 'badge bg-success-subtle text-success border border-success-subtle',
            self::Enrolled => 'badge bg-success text-white',
            self::Rejected => 'badge bg-danger-subtle text-danger border border-danger-subtle',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::Pending => 'bi-hourglass-split',
            self::Shortlisted => 'bi-filter-circle',
            self::InterviewScheduled => 'bi-calendar-event',
            self::Selected => 'bi-award',
            self::Enrolled => 'bi-check2-all',
            self::Rejected => 'bi-x-circle',
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
