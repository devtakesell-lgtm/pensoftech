<?php

namespace App\Enums;

enum SolutionStatus: string
{
    case SUCCESS = 'success';
    case FAILED = 'failed';
    case ATTEMPTED = 'attempted';

    public function label(): string
    {
        return match ($this) {
            self::SUCCESS => 'Success',
            self::FAILED => 'Failed',
            self::ATTEMPTED => 'Attempted',
        };
    }

    public function badgeClass(): string
    {
        return match ($this) {
            self::SUCCESS => 'bg-success',
            self::FAILED => 'bg-danger',
            self::ATTEMPTED => 'bg-secondary',
        };
    }
}
