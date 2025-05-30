<?php

namespace App\Data;

use Spatie\LaravelData\Data;

class OrderListData extends Data
{
    public function __construct(
        public readonly ?string $filter = null,
        public readonly int $offset = 0,
        public readonly int $limit = 50,
        public readonly ?int $seller_id = null,
        public readonly ?string $date_start = null,
        public readonly ?string $date_end = null,
    ) {}
}
