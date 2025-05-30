<?php

namespace App\Repositories\User;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;

class Repository
{
    public function __construct(private User $model) {
        //
    }

    public function all(): Collection
    {
        return $this->model->all();
    }

    public function exists(int $userId): bool
    {
        return $this->model->whereId($userId)->exists();
    }

    public function findById(int $userId): User
    {
        return $this->model->find($userId);
    }

    public function findByEmail(string $email): User|null
    {
        return $this->model
            ->whereEmail(Str::lower($email))
            ->first();
    }
}
