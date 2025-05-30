<?php

namespace App\Repositories\Reports;

use App\Data\DailyOrderReportData;
use App\Models\Comission;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class Repository
{
    private string $orderTable;
    private string $comissionTable;

    public function __construct() {
        $this->orderTable = (new Order())->getTable();
        $this->comissionTable = (new Comission())->getTable();
    }

    public function dailyOrdersReport(string $date, ?int $seller_id = null): DailyOrderReportData
    {
        $report = DB::table($this->orderTable)
            ->select(
                DB::raw("COUNT({$this->orderTable}.id) as quantity"),
                DB::raw("SUM({$this->orderTable}.value) as total"),
                DB::raw("SUM({$this->comissionTable}.value) as total_comission")
            )
            ->join($this->comissionTable, "{$this->orderTable}.id", "{$this->comissionTable}.order_id")
            ->where("{$this->orderTable}.date", $date)
            ->when(!is_null($seller_id), function ($cond) use ($seller_id) {
                $cond->whereSellerId($seller_id);
            })
            ->first();

        return new DailyOrderReportData(
            dateEnToBr($date),
            $report->quantity,
            formatFloatToReal($report->total),
            formatFloatToReal($report->total_comission),
        );
    }
}
