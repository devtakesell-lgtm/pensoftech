<?php

namespace App\Enums;

enum LeadType: string
{
    case NewProject = 'new_project';
    case Retainer = 'retainer';
    case Consultation = 'consultation';
    case Maintenance = 'maintenance';
    case ClientRequest = 'client_request';
    case Other = 'other';

    public function label(): string
    {
        return match ($this) {
            self::NewProject => 'New Project',
            self::Retainer => 'Monthly Retainer',
            self::Consultation => 'Strategic Consultation',
            self::Maintenance => 'Support & Maintenance',
            self::ClientRequest => 'Client Request',
            self::Other => 'Other',
        };
    }

    /**
     * Return associative array of [value => label] for dropdowns and display.
     *
     * @return array<string, string>
     */
    public static function options(): array
    {
        $options = [];
        foreach (self::cases() as $case) {
            $options[$case->value] = $case->label();
        }

        return $options;
    }
}
