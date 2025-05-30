<?php

namespace App\Http\Controllers;

use App\Exceptions\Seller\EmailAlreadyExistsException;
use App\Exceptions\Seller\NotFoundException;
use App\Http\Requests\Seller\StoreRequest;
use App\Http\Requests\Seller\UpdateRequest;
use App\Services\Seller\Service;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class SellerController extends Controller
{
    public function __construct(private Service $service) {
        //
    }

    private function emailAlreadyExistsResponse(): JsonResponse
    {
        return $this->errorResponse(
            "O e-mail informado já está sendo usado para outro vendedor!",
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }

    private function sellerNotFoundResponse(): JsonResponse
    {
        return $this->errorResponse(
            "O vendedor informado é inválido",
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }

    public function index()
    {
        $sellers = $this->service->listSellers();

        return $this->successResponse($sellers);
    }

    public function store(StoreRequest $request)
    {
        try {
            $seller = $this->service->createSeller($request->toData());
        } catch (EmailAlreadyExistsException $e) {
            return $this->emailAlreadyExistsResponse();
        } catch (\Throwable $e) {
            Log::error($e->getMessage());
            return $this->internalErrorResponse('cadastrar o vendedor');
        }

        return $this->successResponse($seller, Response::HTTP_CREATED);
    }

    public function show(int $id)
    {
        try {
           $seller = $this->service->getSeller($id);
        } catch (NotFoundException $e) {
            return $this->sellerNotFoundResponse();
        } catch (\Throwable $e) {
            Log::error($e->getMessage());
            return $this->internalErrorResponse('buscar o vendedor');
        }

        return $this->successResponse($seller);
    }

    public function update(UpdateRequest $request, int $id)
    {
        try {
            $this->service->updateSeller($id, $request->toData());
        } catch (NotFoundException $e) {
            return $this->sellerNotFoundResponse();
        } catch (EmailAlreadyExistsException $e) {
            return $this->emailAlreadyExistsResponse();
        } catch (\Throwable $e) {
            Log::error($e->getMessage());
            return $this->internalErrorResponse('atualizar o vendedor');
        }

        return $this->noContentResponse();
    }

    public function destroy(int $id)
    {
        try {
            $this->service->removeSeller($id);
        } catch (NotFoundException $e) {
            return $this->sellerNotFoundResponse();
        } catch (\Throwable $e) {
            Log::error($e->getMessage());
            return $this->internalErrorResponse('remover o vendedor');
        }

        return $this->noContentResponse();
    }

    public function restore(int $id)
    {
        try {
            $this->service->restoreSeller($id);
        } catch (NotFoundException $e) {
            return $this->sellerNotFoundResponse();
        } catch (\Throwable $e) {
            Log::error($e->getMessage());
            return $this->internalErrorResponse('restaurar o vendedor');
        }

        return $this->noContentResponse();
    }
}
