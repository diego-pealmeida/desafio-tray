<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Resource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'    => $this->id,
            'name'  => $this->name,
            'email' => $this->email,
            'created_at'    => $this->created_at?->setTimezone(new \DateTimeZone('America/Sao_Paulo'))->format('d/m/Y H:i:s'),
            'updated_at'    => $this->created_at?->setTimezone(new \DateTimeZone('America/Sao_Paulo'))->format('d/m/Y H:i:s')
        ];
    }
}
