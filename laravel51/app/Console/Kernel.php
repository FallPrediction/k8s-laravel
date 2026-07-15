<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Cache;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\Inspire::class,
        \App\Console\Commands\Readiness::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('inspire')
                ->everyMinute()
                ->withoutOverlapping()
                ->when(function () {
                    // 定義一個跨伺服器唯一的 Lock Key，不要包含微秒或浮動時間
                    $lockKey = 'framework/schedule-inspire-sync-lock';

                    // 嘗試在 Redis 寫入一個具有時效性的鎖（例如 55 秒後自動過期）
                    // 如果返回 true 代表這台機器搶到了，其他機器在 55 秒內都搶不到
                    return Cache::add($lockKey, true, 0.916); // 5.1 的快取時間是「分鐘」，0.916 分鐘約為 55 秒

                    // 注意：如果您的 Laravel 5.1 有改底層或支援傳入秒數，請設為 55 秒
                    // 或是使用 Redis facade 更精準：
                    // return Redis::set($lockKey, true, 'EX', 55, 'NX');
                });
    }
}
