<?php

namespace App\Services\Seller;

use App\Data\ListData;
use App\Data\ListResponseData;
use App\Data\SellerData;
use App\Exceptions\Seller\EmailAlreadyExistsException;
use App\Exceptions\Seller\NotFoundException;
use App\Models\Seller;
use App\Repositories\Seller\Repository;

class Service
{
    public function __construct(private Repository $repository) {
        //
    }

    public function listSellers(ListData $data): ListResponseData
    {
        return $this->repository->list($data);
    }

    public function getSeller(int $sellerId): Seller
    {
        if (!$this->repository->sellerExists($sellerId))
            throw new NotFoundException("Seller not found");

        return $this->repository->find($sellerId);
    }

    public function createSeller(SellerData $data): Seller
    {
        if ($this->repository->emailExists($data->email))
            throw new EmailAlreadyExistsException("The email is already in use by another seller");

        return $this->repository->create($data);
    }

    public function updateSeller(int $sellerId, SellerData $data): void
    {
        if (!$this->repository->sellerExists($sellerId))
            throw new NotFoundException("Seller not found");

        if (!empty($data->email) && $this->repository->emailExists($data->email, $sellerId))
            throw new EmailAlreadyExistsException("The email is already in use by another seller");

        $this->repository->update($sellerId, $data);
    }

    public function removeSeller(int $sellerId): void
    {
        if (!$this->repository->sellerExists($sellerId))
            throw new NotFoundException("Seller not found");

        $this->repository->remove($sellerId);
    }
}
