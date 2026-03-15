<?php

namespace App\Console\Commands;

use App\Models\LoginHistory;
use Illuminate\Console\Command;

class ExpireLoginHistories extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'loginhist:expire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mark expired login history rows as expired';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = now();

        $updated = LoginHistory::where('status', 'active')
            ->whereNotNull('expires_at')
            ->where('expires_at', '<=', $now)
            ->update([
                'status' => 'expired',
            ]);

        $this->info("Updated {$updated} login histories.");
    }
}
