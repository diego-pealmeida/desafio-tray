<?php

namespace App\Services\Order;

use App\Data\ListResponseData;
use App\Data\OrderData;
use App\Data\OrderListData;
use App\Exceptions\Order\NotFoundException;
use App\Jobs\RefreshDailyOrderCache;
use App\Models\Order;
use App\Repositories\Order\Repository;

class Service
{
    public function __construct(private Repository $repository) {
        //
    }

    public function listOrders(OrderListData $data): ListResponseData
    {
        return $this->repository->list($data);
    }

    public function getOrder(int $orderId): Order
    {
        if (!$this->repository->orderExists($orderId))
            throw new NotFoundException("Order not found");

        return $this->repository->find($orderId);
    }

    public function createOrder(OrderData $data): Order
    {
        return $this->repository->create($data);
    }

    public function updateOrder(int $orderId, OrderData $data): void
    {
        if (!$this->repository->orderExists($orderId))
            throw new NotFoundException("Order not found");

        $this->repository->update($orderId, $data);
    }

    public function removeOrder(int $orderId): void
    {
        if (!$this->repository->orderExists($orderId))
            throw new NotFoundException("Order not found");

        $this->repository->remove($orderId);
    }

    public function refreshOrderComission(int $orderId): void
    {
        if (!$this->repository->orderExists($orderId))
            throw new NotFoundException("Order not found");

        $this->repository->refreshComission($orderId);

        $order = $this->repository->find($orderId);

        RefreshDailyOrderCache::dispatch($order->date, $order->seller_id)->onQueue('low');
    }
}
