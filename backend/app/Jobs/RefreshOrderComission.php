<?php

namespace App\Jobs;

use App\Services\Order\Service;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class RefreshOrderComission implements ShouldQueue
{
    use Queueable;

    public function __construct(private int $orderId)
    {
        //
    }

    public function handle(Service $orderService): void
    {
        $orderService->refreshOrderComission($this->orderId);
    }
}
