<?php

namespace App\Console\Commands;

use App\Enums\QuoteStatus;
use App\Models\Quote;
use Illuminate\Console\Command;

class ExpireQuotesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'quotes:expire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Expire quotes that have passed their valid_until date';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $updatedCount = Quote::where('status', QuoteStatus::Sent)
            ->whereNotNull('valid_until')
            ->whereDate('valid_until', '<', today())
            ->update(['status' => QuoteStatus::Expired]);

        $this->info("Successfully expired {$updatedCount} quotes.");
    }
}
