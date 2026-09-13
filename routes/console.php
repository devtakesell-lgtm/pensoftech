<?php

use App\Enums\QuoteStatus;
use App\Models\Quote;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::call(function () {
    Quote::where('status', QuoteStatus::Sent)
        ->whereNotNull('valid_until')
        ->whereDate('valid_until', '<', today())
        ->update(['status' => QuoteStatus::Expired]);
})->daily()->name('expire-quotes');
