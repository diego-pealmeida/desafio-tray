<?php

namespace App\Http\Requests\Seller;

class UpdateRequest extends Request
{
    public function rules(): array
    {
        return [
            'name'  => 'filled|min:3|max:60',
            'email' => 'filled|email|max:255'
        ];
    }
}
