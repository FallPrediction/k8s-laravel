<?php

namespace App\Monitoring;

use Prometheus\CollectorRegistry;
use Prometheus\Storage\Redis;

class PrometheusRegistry
{
    /**
     * Create a registry backed by Redis, shared by all PHP-FPM workers.
     *
     * @return \Prometheus\CollectorRegistry
     */
    public static function make()
    {
        Redis::setDefaultOptions(config('prometheus.redis'));

        return new CollectorRegistry(new Redis());
    }
}
