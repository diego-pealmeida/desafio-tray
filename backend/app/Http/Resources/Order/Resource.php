<?php

namespace App\Http\Resources\Order;

use App\Http\Resources\Seller\Resource as SellerResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Resource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'                => $this->id,
            'value'             => $this->value,
            'value_formated'    => formatFloatToReal($this->value),
            'date'              => $this->date,
            'date_formated'     => dateEnToBr($this->date),
            'seller'            => new SellerResource($this->seller),
            'seller_name'       => $this->seller->name,
            'commission'        => formatFloatToReal($this->comission->value),
            'created_at'        => $this->created_at?->setTimezone(new \DateTimeZone('America/Sao_Paulo'))->format('d/m/Y H:i:s'),
            'updated_at'        => $this->created_at?->setTimezone(new \DateTimeZone('America/Sao_Paulo'))->format('d/m/Y H:i:s')
        ];
    }
}
