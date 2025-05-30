<?php

namespace App\Http\Requests\Order;

use App\Data\OrderData;
use App\Http\Requests\BaseRequest;

class Request extends BaseRequest
{
    public function toData(): OrderData
    {
        return new OrderData(
            $this->input('seller_id'),
            $this->input('value'),
            $this->input('date'),
            $this->user()->id
        );
    }
}
