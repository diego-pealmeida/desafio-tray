<?php

namespace App\Observers;

use App\Jobs\RefreshDailyOrderCache;
use App\Jobs\RefreshOrderComission;
use App\Models\Order;

class OrderObserver
{
    public function saved(Order $order)
    {
        RefreshOrderComission::dispatch($order->id)->onQueue('high');
    }

    public function updated(Order $order)
    {
        $dateOriginal = $order->getOriginal('date');
        $sellerOriginal = $order->getOriginal('seller_id');

        if ($dateOriginal != $order->date || $sellerOriginal != $order->seller_id)
            RefreshDailyOrderCache::dispatch($order->date, $order->seller_id)
                ->onQueue('low')
                ->delay(now()->addSeconds(10));
    }

    public function deleted(Order $order)
    {
        RefreshDailyOrderCache::dispatch($order->date, $order->seller_id)
            ->onQueue('low');
    }
}
