<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Order\OrderController;

Route::get("/api/orders/{id?}", [OrderController::class, "get"]);
Route::post("/api/orders", [OrderController::class, "register"]);
Route::put("/api/orders/{id}", [OrderController::class, "update"]);