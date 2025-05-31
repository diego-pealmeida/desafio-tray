<?php

namespace App\Http\Requests;

use App\Data\ListData;

class ListRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'filter' => 'nullable|string',
            'offset' => 'filled|integer',
            'limit'  => 'filled|integer|between:1,200'
        ];
    }

    public function toData(): ListData
    {
        return new ListData(
            $this->input('filter'),
            $this->input('offset', 0),
            $this->input('limit', 50)
        );
    }
}
