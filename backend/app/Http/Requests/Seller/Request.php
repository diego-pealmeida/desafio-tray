<?php

namespace App\Http\Requests\Seller;

use App\Data\SellerData;
use App\Http\Requests\BaseRequest;

class Request extends BaseRequest
{
    public function toData(): SellerData
    {
        return new SellerData(
            $this->input('name'),
            $this->input('email'),
            $this->user()->id
        );
    }
}
