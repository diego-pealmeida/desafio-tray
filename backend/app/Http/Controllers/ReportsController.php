<?php

namespace App\Http\Controllers;

use App\Http\Requests\Reports\ResendDailyOrderReportRequest;
use App\Services\Reports\Service;

class ReportsController extends Controller
{
    public function __construct(private Service $reportService) {
        //
    }

    public function resendSellerDailyOrder(ResendDailyOrderReportRequest $request, int $id)
    {
        $this->reportService->resendSellerDailyOrderReport($id, $request->toData());
    }
}
