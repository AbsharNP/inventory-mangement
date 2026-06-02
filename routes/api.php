<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\StockController;
use App\Http\Controllers\Api\WarehouseController;
use App\Http\Middleware\LogRequestTime;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login'])->middleware(LogRequestTime::class);

Route::middleware(['auth:sanctum', LogRequestTime::class])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/products', [ProductController::class, 'index']);
    Route::post('/stock', [StockController::class, 'store']);

    Route::get('/warehouses', [WarehouseController::class, 'index']);
    Route::get('/warehouses/{id}/report', [WarehouseController::class, 'report']);
});
