<?php

namespace App\Http\Middleware;

use App\Monitoring\PrometheusRegistry;
use Closure;

class RecordPrometheusMetrics
{
    /**
     * Record completed HTTP requests by their matched route template.
     */
    public function handle($request, Closure $next)
    {
        $startedAt = microtime(true);

        try {
            return $next($request);
        } finally {
            // Do not count Prometheus scrapes as application traffic.
            if ($request->path() !== 'metrics') {
                $route = $request->route();
                $routeName = $this->routeName($route);
                $registry = PrometheusRegistry::make();

                $registry->getOrRegisterCounter(
                    '',
                    'http_requests_total',
                    'Total number of HTTP requests received.',
                    ['route']
                )->inc([$routeName]);

                $registry->getOrRegisterHistogram(
                    '',
                    'http_request_duration_seconds',
                    'HTTP request duration in seconds.',
                    ['route'],
                    [0.1, 0.5, 2.5, 12.5, 62.5]
                )->observe(microtime(true) - $startedAt, [$routeName]);
            }
        }
    }

    /**
     * Prefer the route template to avoid unbounded label cardinality.
     *
     * @param mixed $route
     * @return string
     */
    private function routeName($route)
    {
        if (is_object($route) && method_exists($route, 'uri')) {
            return '/' . ltrim($route->uri(), '/');
        }

        return 'unmatched';
    }
}
