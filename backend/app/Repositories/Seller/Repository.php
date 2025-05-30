<?php

namespace App\Repositories\Seller;

use App\Data\SellerData;
use App\Exceptions\Seller\CreateException;
use App\Exceptions\Seller\UpdateException;
use App\Exceptions\Seller\DeleteException;
use App\Exceptions\Seller\RestoreException;
use App\Models\Seller;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;

class Repository
{
    public function __construct(private Seller $model) {
        //
    }

    public function sellerExists(int $sellerId, bool $checkDeleted = false): bool
    {
        return $this->model
            ->when($checkDeleted, function ($cond) {
                $cond->withTrashed();
            })
            ->whereId($sellerId)->exists();
    }

    public function emailExists(string $email, ?int $sellerId = null): bool
    {
        return $this->model
            ->when(!is_null($sellerId), function ($cond) use ($sellerId) {
                $cond->whereNot('id', $sellerId);
            })
            ->whereEmail(Str::lower($email))->exists();
    }

    public function all(): Collection
    {
        return $this->model->all();
    }

    public function find(int $sellerId): Seller
    {
        return $this->model->find($sellerId);
    }

    public function create(SellerData $data): Seller
    {
        $this->model->name = $data->name;
        $this->model->email = Str::lower($data->email);
        $this->model->creator_id = $data->creator_id;

        if (!$this->model->save())
            throw new CreateException("An error ocurred when trying to create the seller. Data: " . $data->toJson());

        return $this->model;
    }

    public function update(int $sellerId, SellerData $data): void
    {
        $seller = $this->find($sellerId);
        $seller->name = $data->name ?: $seller->name;
        $seller->email = $data->email ?: $seller->email;

        if (!$seller->save())
            throw new UpdateException("An error ocurred when trying to update the seller. ID: $sellerId Data: " . $data->toJson());
    }

    public function remove(int $sellerId): void
    {
        $deleted = $this->model
            ->whereId($sellerId)
            ->delete();

        if (!$deleted)
            throw new DeleteException("An error ocurred when trying to remove the seller. ID: $sellerId");
    }

    public function restore(int $sellerId): void
    {
        $restored = $this->model
            ->whereId($sellerId)
            ->restore();

        if (!$restored)
            throw new RestoreException("An error ocurred when trying to restore the seller. ID: $sellerId");
    }
}
