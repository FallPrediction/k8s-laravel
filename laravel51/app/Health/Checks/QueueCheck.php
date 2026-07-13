<?php

namespace App\Health\Checks;

use App\Health\CheckResult;
use Illuminate\Support\Facades\Queue;
use Exception;

class QueueCheck implements CheckInterface
{
    /**
     * @var string|null 佇列連線名稱 (如 'redis', 'database', 'beanstalkd')
     */
    protected $connection;

    /**
     * @var string|null 佇列名稱 (如 'default', 'emails')
     */
    protected $queue;

    public function __construct(string $connection = null, string $queue = null)
    {
        $this->connection = $connection;
        $this->queue = $queue;
    }

    public function run(): CheckResult
    {
        try {
            // 嘗試取得佇列的大小。
            // 如果 Queue 的底層伺服器掛掉，這裡會拋出 Exception (例如 Redis 斷線)
            $size = Queue::connection($this->connection)->size($this->queue);

            // 這裡你也可以加入邏輯：如果 $size 大於某個危險值（例如 10000），就回傳 false
            // 但如果純粹給 K8S 檢查連線狀態，只要能拿到 size 就代表連線正常

            return new CheckResult('Queue', true, "Connected. Current size: {$size}");
        } catch (Exception $e) {
            return new CheckResult('Queue', false, 'Queue connection failed: ' . $e->getMessage());
        }
    }
}
