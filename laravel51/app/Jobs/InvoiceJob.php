<?php

namespace App\Jobs;

use Carbon\Carbon;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use Log;

class InvoiceJob extends Job implements ShouldQueue, SelfHandling
{
    /**
     * Execute the job.
     */
    public function handle()
    {
        Log::info('Invoice job executed', [
            'job' => 'invoice',
            'timestamp' => Carbon::now()->toDateTimeString(),
        ]);
    }
}
