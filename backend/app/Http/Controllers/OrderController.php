<?php

namespace App\Http\Controllers;

use App\Exceptions\Order\NotFoundException;
use App\Http\Requests\Order\ListRequest;
use App\Http\Requests\Order\StoreRequest;
use App\Http\Requests\Order\UpdateRequest;
use App\Http\Resources\Order\ListResource;
use App\Services\Order\Service;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function __construct(private Service $service) {
        //
    }

    private function orderNotFoundResponse(): JsonResponse
    {
        return $this->errorResponse(
            "A venda informada é inválida",
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }

    public function index(ListRequest $request)
    {
        $list = $this->service->listOrders($request->toData());

        return $this->successResponse(new ListResource($list));
    }

    public function store(StoreRequest $request)
    {
        try {
            $order = $this->service->createOrder($request->toData());
        } catch (\Throwable $e) {
            Log::error($e->getMessage());
            return $this->internalErrorResponse('cadastrar a venda');
        }

        return $this->successResponse($order, Response::HTTP_CREATED);
    }

    public function show(int $id)
    {
        try {
           $order = $this->service->getOrder($id);
        } catch (NotFoundException $e) {
            return $this->orderNotFoundResponse();
        } catch (\Throwable $e) {
            Log::error($e->getMessage());
            return $this->internalErrorResponse('buscar a venda');
        }

        return $this->successResponse($order);
    }

    public function update(UpdateRequest $request, int $id)
    {
        try {
            $this->service->updateOrder($id, $request->toData());
        } catch (NotFoundException $e) {
            return $this->orderNotFoundResponse();
        } catch (\Throwable $e) {
            Log::error($e->getMessage());
            return $this->internalErrorResponse('atualizar a venda');
        }

        return $this->noContentResponse();
    }

    public function destroy(int $id)
    {
        try {
            $this->service->removeOrder($id);
        } catch (NotFoundException $e) {
            return $this->orderNotFoundResponse();
        } catch (\Throwable $e) {
            Log::error($e->getMessage());
            return $this->internalErrorResponse('remover a venda');
        }

        return $this->noContentResponse();
    }
}
