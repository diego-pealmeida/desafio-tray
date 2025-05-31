<?php

namespace App\Http\Requests\Reports;

use App\Data\ResendDailyOrderReportData;
use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class ResendDailyOrderReportRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'date' => [
                'required',
                'date_format:Y-m-d',
                Rule::date()->beforeOrEqual(today(new \DateTimeZone('America/Sao_Paulo')))
            ]
        ];
    }

    public function toData(): ResendDailyOrderReportData
    {
        return new ResendDailyOrderReportData($this->input('date'));
    }
}
