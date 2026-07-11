<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Health\Checks\DatabaseCheck;
use App\Health\Checks\RedisCheck;

class Readiness extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'readiness';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $checks = [
            new DatabaseCheck(),
            new RedisCheck(),
        ];

        foreach ($checks as $key => $check) {
            if (!$check->run()->isOk) {
                return 1;
            }
        }
        return 0;
    }
}
