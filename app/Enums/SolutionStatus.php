<?php

namespace App\Enums;

enum SolutionStatus: string
{
    case Success = 'success';
    case Failed = 'failed';
    case Attempted = 'attempted';

    public function label(): string
    {
        return match ($this) {
            self::Success => 'Success',
            self::Failed => 'Failed',
            self::Attempted => 'Attempted',
        };
    }

    public function badgeClass(): string
    {
        return match ($this) {
            self::Success => 'bg-success',
            self::Failed => 'bg-danger',
            self::Attempted => 'bg-secondary',
        };
    }
}
