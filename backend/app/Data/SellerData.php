<?php

namespace App\Data;

use Spatie\LaravelData\Data;

class SellerData extends Data
{
    public function __construct(
        public readonly ?string $name = null,
        public readonly ?string $email = null,
        public readonly ?int $creator_id = null
    ) {}
}
