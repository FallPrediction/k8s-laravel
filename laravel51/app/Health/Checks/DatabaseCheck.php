<?php

namespace App\Health\Checks;

use App\Health\CheckResult;
use Illuminate\Support\Facades\DB;
use Exception;

class DatabaseCheck implements CheckInterface
{
    public function run(): CheckResult
    {
        try {
            // 嘗試取得 PDO 實例，若連線失敗會拋出例外
            DB::connection()->getPdo();
            return new CheckResult('Database', true, 'Connected successfully.');
        } catch (Exception $e) {
            return new CheckResult('Database', false, $e->getMessage());
        }
    }
}
