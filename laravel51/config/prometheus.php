<?php

return [
    /*
    | Redis is shared by the PHP-FPM workers, so counters and histograms
    | survive individual request processes and can be scraped by Prometheus.
    */
    'redis' => [
        'host' => env('PROMETHEUS_REDIS_HOST', env('REDIS_HOST', 'localhost')),
        'port' => env('PROMETHEUS_REDIS_PORT', env('REDIS_PORT', 6379)),
        'password' => env('PROMETHEUS_REDIS_PASSWORD', env('REDIS_PASSWORD', null)),
        'database' => env('PROMETHEUS_REDIS_DATABASE', 15),
        'timeout' => env('PROMETHEUS_REDIS_TIMEOUT', 0.1),
        'read_timeout' => env('PROMETHEUS_REDIS_READ_TIMEOUT', 10),
        'persistent_connections' => false,
    ],
];
