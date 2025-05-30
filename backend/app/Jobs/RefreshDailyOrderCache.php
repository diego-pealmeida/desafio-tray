<?php

namespace App\Jobs;

use App\Services\Reports\Service;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class RefreshDailyOrderCache implements ShouldQueue
{
    use Queueable;

    public function __construct(
        private readonly string $date,
        private readonly ?int $seller_id = null
    ) {
        //
    }

    public function handle(Service $reportService): void
    {
        $reportService->refreshDailyOrdersReportCache($this->date, $this->seller_id);
        $reportService->refreshDailyOrdersReportCache($this->date);
    }
}
