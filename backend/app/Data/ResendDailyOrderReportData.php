<?php

namespace App\Data;

use Spatie\LaravelData\Data;

class ResendDailyOrderReportData extends Data
{
    public function __construct(
        public readonly string $date
    ) {}
}
