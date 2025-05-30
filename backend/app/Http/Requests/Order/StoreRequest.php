<?php

namespace App\Http\Requests\Order;

use Illuminate\Validation\Rule;

class StoreRequest extends Request
{
    public function rules(): array
    {
        return [
            'seller_id' => 'required|integer|exists:sellers,id',
            'value'     => 'required|numeric|decimal:0,2|max:99999999.99',
            'date'      => [
                'required',
                'date_format:Y-m-d',
                Rule::date()->beforeOrEqual(today(new \DateTimeZone('America/Sao_Paulo')))
            ]
        ];
    }
}
