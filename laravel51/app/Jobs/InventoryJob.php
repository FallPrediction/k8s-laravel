<?php

namespace App\Jobs;

use Carbon\Carbon;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use Log;

class InventoryJob extends Job implements ShouldQueue, SelfHandling
{
    /**
     * Execute the job.
     */
    public function handle()
    {
        Log::info('Inventory job executed', [
            'job' => 'inventory',
            'timestamp' => Carbon::now()->toDateTimeString(),
        ]);
    }
}
