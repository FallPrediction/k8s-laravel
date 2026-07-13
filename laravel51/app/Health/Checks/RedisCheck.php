<?php

namespace App\Health\Checks;

use App\Health\CheckResult;
use Illuminate\Support\Facades\Redis;
use Exception;

class RedisCheck implements CheckInterface
{
    public function run(): CheckResult
    {
        try {
            // Laravel 5.1 使用 predis，呼叫 ping 應回傳 "+PONG" 或 true
            $response = Redis::connection()->ping();
            if ($response) {
                return new CheckResult('Redis', true, 'Connected successfully.');
            }
            return new CheckResult('Redis', false, 'Ping failed.');
        } catch (Exception $e) {
            return new CheckResult('Redis', false, $e->getMessage());
        }
    }
}
