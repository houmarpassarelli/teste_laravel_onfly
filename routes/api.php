<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Order\OrderController;

Route::post("/api/orders/list", [OrderController::class, "fetch"]);
Route::post("/api/orders", [OrderController::class, "register"]);
Route::put("/api/orders/{id}", [OrderController::class, "update"]);