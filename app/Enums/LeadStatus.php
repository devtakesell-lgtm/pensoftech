<?php

namespace App\Enums;

enum LeadStatus: string
{
    case New = 'new';
    case Contacted = 'contacted';
    case Qualified = 'qualified';
    case ProposalSent = 'proposal_sent';
    case Converted = 'converted';
    case Lost = 'lost';

    public function label(): string
    {
        return match ($this) {
            self::New => 'New',
            self::Contacted => 'Contacted',
            self::Qualified => 'Qualified',
            self::ProposalSent => 'Proposal Sent',
            self::Converted => 'Converted',
            self::Lost => 'Lost',
        };
    }

    public function badgeClass(): string
    {
        return match ($this) {
            self::New => 'lead-status-new',
            self::Contacted => 'lead-status-contacted',
            self::Qualified => 'lead-status-qualified',
            self::ProposalSent => 'lead-status-proposal_sent',
            self::Converted => 'lead-status-converted',
            self::Lost => 'lead-status-lost',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::New => 'bi-stars',
            self::Contacted => 'bi-telephone-forward',
            self::Qualified => 'bi-patch-check',
            self::ProposalSent => 'bi-send-check',
            self::Converted => 'bi-trophy',
            self::Lost => 'bi-x-circle',
        };
    }

    public static function options(): array
    {
        return array_map(fn ($case) => ['value' => $case->value, 'label' => $case->label()], self::cases());
    }

    public function isValidTransitionTo(self|string $newStatus): bool
    {
        $newStatusValue = $newStatus instanceof self ? $newStatus->value : $newStatus;

        $pipelineStages = [
            self::New->value,
            self::Contacted->value,
            self::Qualified->value,
            self::ProposalSent->value,
            self::Converted->value,
        ];

        $currentIndex = array_search($this->value, $pipelineStages);
        $newIndex = array_search($newStatusValue, $pipelineStages);

        if ($this !== self::Lost && $currentIndex !== false && $newIndex !== false && $newIndex < $currentIndex) {
            return false;
        }

        return true;
    }
}
