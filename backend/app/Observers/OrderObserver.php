<?php

namespace App\Observers;

use App\Jobs\RefreshDailyOrderCache;
use App\Jobs\RefreshOrderComission;
use App\Models\Order;

class OrderObserver
{
    public function saved(Order $order)
    {
        RefreshOrderComission::dispatchSync($order->id);
    }

    public function updated(Order $order)
    {
        $date_original = $order->getOriginal('date');
        $seller_id_original = $order->getOriginal('seller_id');

        if ($date_original != $order->date || $seller_id_original != $order->seller_id)
            RefreshDailyOrderCache::dispatch($date_original, $seller_id_original)
                ->onQueue('low')
                ->delay(now()->addSeconds(10));
    }

    public function deleted(Order $order)
    {
        RefreshDailyOrderCache::dispatch($order->date, $order->seller_id)
            ->onQueue('low');
    }
}
