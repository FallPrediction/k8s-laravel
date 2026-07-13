<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Health\Checks\PingCheck;
use App\Health\Checks\DatabaseCheck;
use App\Health\Checks\RedisCheck;

class HealthController extends Controller
{
    /**
     * K8S Liveness Probe (存活探針：只查自己，掛了就重啟)
     */
    public function liveness(): JsonResponse
    {
        $checks = [
            new PingCheck(),
        ];

        return $this->runChecks($checks);
    }

    /**
     * K8S Readiness Probe (就緒探針：查外部依賴，掛了就拔除流量)
     */
    public function readiness(): JsonResponse
    {
        $checks = [
            new DatabaseCheck(),
            new RedisCheck(),
        ];

        return $this->runChecks($checks);
    }

    /**
     * 執行檢查陣列並統整回應
     *
     * @param \App\Health\Checks\CheckInterface[] $checks
     * @return JsonResponse
     */
    private function runChecks(array $checks): JsonResponse
    {
        $status = 200;
        $results = [];

        foreach ($checks as $check) {
            $result = $check->run();
            
            $results[$result->name] = [
                'status'  => $result->isOk ? 'ok' : 'failed',
                'message' => $result->message,
            ];

            // 只要有一個檢查失敗，HTTP 狀態碼就改為 503 (Service Unavailable)
            if (! $result->isOk) {
                $status = 503;
            }
        }

        return response()->json([
            'status'  => $status === 200 ? 'healthy' : 'unhealthy',
            'details' => $results,
        ], $status);
    }

    /**
     * Queue Worker 專用的 Probe
     * 檢查 Worker 是否有成功連上 Queue Server
     */
    public function workerReadiness(): \Illuminate\Http\JsonResponse
    {
        $checks = [
            // 預設檢查 .env 中的 QUEUE_DRIVER 連線
            new \App\Health\Checks\QueueCheck(), 
            
            // 如果你想指定檢查特定連線或特定佇列，可以這樣傳：
            // new \App\Health\Checks\QueueCheck('redis', 'emails'), 
        ];

        return $this->runChecks($checks);
    }
}
