<?php

namespace App\Health\Checks;

use App\Health\CheckResult;

interface CheckInterface
{
    /**
     * 執行檢查並回傳結果
     *
     * @return CheckResult
     */
    public function run(): CheckResult;
}
