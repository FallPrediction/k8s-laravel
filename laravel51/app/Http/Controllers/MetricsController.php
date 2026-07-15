<?php

namespace App\Http\Controllers;

use App\Monitoring\PrometheusRegistry;
use Prometheus\RenderTextFormat;

class MetricsController extends Controller
{
    /**
     * Render metrics in Prometheus' text exposition format.
     */
    public function index()
    {
        $renderer = new RenderTextFormat();
        $content = $renderer->render(PrometheusRegistry::make()->getMetricFamilySamples());

        return response($content, 200, ['Content-Type' => RenderTextFormat::MIME_TYPE]);
    }
}
