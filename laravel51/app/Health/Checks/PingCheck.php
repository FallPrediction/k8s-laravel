<?php

namespace App\Health\Checks;

use App\Health\CheckResult;

class PingCheck implements CheckInterface
{
    public function run(): CheckResult
    {
        // 只要這段程式碼能執行，代表 PHP-FPM 與 Laravel 核心是活著的
        return new CheckResult('Ping', true, 'Pong');
    }
}
