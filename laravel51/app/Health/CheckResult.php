<?php

namespace App\Health;

class CheckResult
{
    public $name;
    public $isOk;
    public $message;

    public function __construct(string $name, bool $isOk, string $message = 'OK')
    {
        $this->name = $name;
        $this->isOk = $isOk;
        $this->message = $message;
    }
}
