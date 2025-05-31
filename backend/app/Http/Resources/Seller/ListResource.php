<?php

namespace App\Http\Resources\Seller;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ListResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'data'              => Resource::collection($this->data),
            'total'             => $this->total,
            'total_filtered'    => $this->total_filtered
        ];
    }
}
