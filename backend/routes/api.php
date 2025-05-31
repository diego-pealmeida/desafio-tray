<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('auth/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('auth/logout', [AuthController::class, 'logout']);
    Route::get('users/me', [UserController::class, 'me']);

    Route::post('sellers/{id}/restore', [SellerController::class, 'restore']);
    Route::apiResource('sellers', SellerController::class);

    Route::apiResource('orders', OrderController::class);

    Route::post('reports/send/orders/daily/sellers/{id}', [ReportsController::class, 'resendSellerDailyOrder']);
});
