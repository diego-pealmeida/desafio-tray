<?php

namespace App\Data;

use Spatie\LaravelData\Data;

class LoginData extends Data
{
    public function __construct(
        public readonly string $email,
        public readonly string $password,
        public readonly bool $remember_me
    ) {}
}
