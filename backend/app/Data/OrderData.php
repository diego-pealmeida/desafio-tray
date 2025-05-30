<?php

namespace App\Data;

use Spatie\LaravelData\Data;

class OrderData extends Data
{
    public function __construct(
        public readonly ?int $seller_id = null,
        public readonly ?float $value = null,
        public readonly ?string $date = null,
        public readonly ?int $creator_id = null
    ) {}
}
