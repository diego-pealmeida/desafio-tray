<?php

namespace App\Data;

use Spatie\LaravelData\Data;

class ListData extends Data
{
    public function __construct(
        public readonly ?string $filter = null,
        public readonly int $offset = 0,
        public readonly int $limit = 50
    ) {}
}
