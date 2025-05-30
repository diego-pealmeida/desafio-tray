<?php

namespace App\Http\Requests\Order;

use Illuminate\Validation\Rule;

class UpdateRequest extends Request
{
    public function rules(): array
    {
        return [
            'seller_id' => 'filled|integer|exists:sellers,id',
            'value'     => 'filled|decimal:0,2|max:99999999.99',
            'date'      => [
                'filled',
                'date_format:Y-m-d',
                Rule::date()->beforeOrEqual(today(new \DateTimeZone('America/Sao_Paulo')))
            ]
        ];
    }
}
