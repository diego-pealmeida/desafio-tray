<?php

namespace App\Http\Requests\Seller;

class StoreRequest extends Request
{
    public function rules(): array
    {
        return [
            'name'  => 'required|min:3|max:60',
            'email' => 'required|email|max:255'
        ];
    }
}
