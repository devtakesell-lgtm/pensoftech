<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            ['key' => 'company_name', 'value' => 'PensoftTech'],
            ['key' => 'contact_email', 'value' => 'hello@pensofttech.com'],
            ['key' => 'contact_phone', 'value' => '+8801618-854811'],
            ['key' => 'office_location', 'value' => 'Third Floor, Darussalam Tower, Kollyanpur, Mirpur Road, Dhaka-1207'],
            ['key' => 'working_hours', 'value' => 'Sat- thu (9am -6pm)'],
            ['key' => 'default_currency', 'value' => 'BDT'],
            ['key' => 'seo_meta_title', 'value' => 'PenSoftTech - Software Development & Digital Marketing'],
            ['key' => 'seo_meta_description', 'value' => 'Custom software and digital marketing under one accountable roof.'],
            ['key' => 'seo_meta_keywords', 'value' => 'software development, digital marketing, SEO'],
            ['key' => 'seo_og_image', 'value' => ''],
            ['key' => 'ga_id', 'value' => ''],
            ['key' => 'gtm_id', 'value' => ''],
            ['key' => 'meta_pixel_id', 'value' => ''],
            ['key' => 'custom_header_scripts', 'value' => ''],
            ['key' => 'custom_footer_scripts', 'value' => ''],
            ['key' => 'facebook_url', 'value' => ''],
            ['key' => 'linkedin_url', 'value' => ''],
            ['key' => 'twitter_url', 'value' => ''],
            ['key' => 'instagram_url', 'value' => ''],
            ['key' => 'youtube_url', 'value' => ''],
            ['key' => 'github_url', 'value' => ''],
            ['key' => 'system_admin_email', 'value' => 'admin@pensofttech.com'],
            ['key' => 'slack_webhook_url', 'value' => ''],
            ['key' => 'auto_approve_comments', 'value' => '0'],
        ];

        foreach ($settings as $setting) {
            \App\Models\Setting::updateOrCreate(
                ['key' => $setting['key']],
                ['value' => $setting['value']]
            );
        }
    }
}
