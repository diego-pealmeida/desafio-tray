<?php

namespace App\Http\Requests\Order;

use App\Data\OrderListData;
use App\Http\Requests\BaseRequest;

class ListRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'filter'        => 'nullable|string',
            'offset'        => 'filled|integer',
            'limit'         => 'filled|integer|between:1,200',
            'seller_id'     => 'nullable|integer',
            'date_start'    => 'nullable|date_format:Y-m-d',
            'date_end'      => 'nullable|date_format:Y-m-d'
        ];
    }

    public function toData(): OrderListData
    {
        return new OrderListData(
            $this->input('filter'),
            $this->input('offset', 0),
            $this->input('limit', 50),
            $this->input('seller_id'),
            $this->input('date_start'),
            $this->input('date_end')
        );
    }
}
