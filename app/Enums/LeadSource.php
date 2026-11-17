<?php

namespace App\Enums;

enum LeadSource: string
{
    case Website = 'website';
    case Referral = 'referral';
    case LinkedIn = 'linkedin';
    case GoogleAds = 'google_ads';
    case FacebookAds = 'facebook_ads';
    case ColdEmail = 'cold_email';
    case Event = 'event';
    case ClientPortal = 'client_portal';
    case Other = 'other';

    public function label(): string
    {
        return match ($this) {
            self::Website => 'Website Inquiry',
            self::Referral => 'Client Referral',
            self::LinkedIn => 'LinkedIn',
            self::GoogleAds => 'Google Ads',
            self::FacebookAds => 'Meta / FB Ads',
            self::ColdEmail => 'Cold Outreach',
            self::Event => 'Event / Conference',
            self::ClientPortal => 'Client Portal',
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
