<?php

namespace App\Data;

use Spatie\LaravelData\Data;

class DailyOrderReportData extends Data
{
    public function __construct(
        public readonly string $date,
        public readonly int $quantity,
        public readonly string $total,
        public readonly string $total_comission,
    ) {}
}
