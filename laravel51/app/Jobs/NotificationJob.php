<?php

namespace App\Jobs;

use Carbon\Carbon;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use Log;

class NotificationJob extends Job implements ShouldQueue, SelfHandling
{
    /**
     * Execute the job.
     */
    public function handle()
    {
        Log::info('Notification job executed', [
            'job' => 'notification',
            'timestamp' => Carbon::now()->toDateTimeString(),
        ]);
    }
}
