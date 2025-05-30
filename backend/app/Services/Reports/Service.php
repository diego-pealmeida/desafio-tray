<?php

namespace App\Services\Reports;

use App\Data\DailyOrderReportData;
use App\Data\ResendDailyOrderReportData;
use App\Jobs\SendSellersDailyOrderEmails;
use App\Repositories\Reports\Repository;

class Service
{
    private string $dailyOrderCacheKey = "daily_order_report_seller_%d_%s";

    public function __construct(private Repository $repository) {
        //
    }

    public function getDailyOrderCacheKey(string $date, ?int $seller_id = null): string
    {
        return sprintf($this->dailyOrderCacheKey, $seller_id, $date);
    }

    public function getDailyOrdersReport(string $date, ?int $seller_id = null): DailyOrderReportData
    {
        $cacheKey = $this->getDailyOrderCacheKey($date, $seller_id);

        if (\Cache::has($cacheKey))
            return \Cache::get($cacheKey);

        return $this->refreshDailyOrdersReportCache($date, $seller_id);
    }

    public function refreshDailyOrdersReportCache(string $date, ?int $seller_id = null): DailyOrderReportData
    {
        $report = $this->repository->dailyOrdersReport($date, $seller_id);

        $cacheKey = $this->getDailyOrderCacheKey($date, $seller_id);

        \Cache::put($cacheKey, $report);

        return $report;
    }

    public function resendSellerDailyOrderReport(int $seller_id, ResendDailyOrderReportData $data)
    {
        SendSellersDailyOrderEmails::dispatch($data->date, $seller_id)
            ->onQueue('low');
    }
}
