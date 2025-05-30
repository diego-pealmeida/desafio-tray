<?php

namespace App\Repositories\Order;

use App\Data\ListResponseData;
use App\Data\OrderData;
use App\Data\OrderListData;
use App\Exceptions\Order\CreateException;
use App\Exceptions\Order\DeleteException;
use App\Exceptions\Order\RefreshComissionException;
use App\Exceptions\Order\UpdateException;
use App\Models\Order;

class Repository
{
    public function __construct(private Order $model) {
        //
    }

    public function orderExists(int $orderId): bool
    {
        return $this->model
            ->whereId($orderId)->exists();
    }

    public function list(OrderListData $data): ListResponseData
    {
        $total = $totalFiltered = $this->model->count();

        $orders = $this->model
            ->when(!is_null($data->seller_id), function ($cond) use ($data) {
                $cond->whereSellerId($data->seller_id);
            })
            ->when(!empty($data->date_start), function ($cond) use ($data) {
                $cond->where('date', '>=', $data->date_start);
            })
            ->when(!empty($data->date_end), function ($cond) use ($data) {
                $cond->where('date', '<=', $data->date_end);
            });

        $totalFiltered = $orders->count();

        $orders = $orders
            ->limit($data->limit)
            ->offset(($data->offset * $data->limit))
            ->get();

        return new ListResponseData($orders, $total, $totalFiltered);
    }

    public function find(int $orderId): Order
    {
        return $this->model->find($orderId);
    }

    public function create(OrderData $data): Order
    {
        $this->model->seller_id = $data->seller_id;
        $this->model->value = $data->value;
        $this->model->date = $data->date;
        $this->model->creator_id = $data->creator_id;

        if (!$this->model->save())
            throw new CreateException("An error ocurred when trying to create the order. Data: " . $data->toJson());

        return $this->model;
    }

    public function update(int $orderId, OrderData $data): void
    {
        $order = $this->find($orderId);
        $order->seller_id = $data->seller_id ?: $order->seller_id;
        $order->value = $data->value ?: $order->value;
        $order->date = $data->date ?: $order->date;

        if (!$order->save())
            throw new UpdateException("An error ocurred when trying to update the order. ID: $orderId Data: " . $data->toJson());
    }

    public function remove(int $orderId): void
    {
        $deleted = $this->model
            ->whereId($orderId)
            ->delete();

        if (!$deleted)
            throw new DeleteException("An error ocurred when trying to remove the order. ID: $orderId");
    }

    public function refreshComission(int $orderId): void
    {
        $order = $this->find($orderId);

        $comissionValue = round(($order->value * 0.085), 2);

        $saved = $order->comission()->updateOrCreate(
            ['order_id' => $order->id],
            [
                'value' => $comissionValue,
                'percentage' => 8.5
            ]
        );

        if (!$saved)
            throw new RefreshComissionException("An erro ocurred when trying to refresh the order comission. ID: $orderId");
    }
}
