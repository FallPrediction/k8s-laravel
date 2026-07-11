<?php

namespace App\Http\Controllers;

use App\Jobs\InventoryJob;
use App\Jobs\InvoiceJob;
use App\Jobs\NotificationJob;
use Illuminate\Http\JsonResponse;
use Queue;

class JobController extends Controller
{
    public function dispatchInventory(): JsonResponse
    {
        Queue::pushOn('inventory', new InventoryJob());

        return response()->json([
            'queued' => true,
            'queue' => 'inventory',
            'job' => 'inventory',
        ], 202);
    }

    public function dispatchNotification(): JsonResponse
    {
        Queue::pushOn('notification', new NotificationJob());

        return response()->json([
            'queued' => true,
            'queue' => 'notification',
            'job' => 'notification',
        ], 202);
    }

    public function dispatchInvoice(): JsonResponse
    {
        Queue::pushOn('invoice', new InvoiceJob());

        return response()->json([
            'queued' => true,
            'queue' => 'invoice',
            'job' => 'invoice',
        ], 202);
    }
}
