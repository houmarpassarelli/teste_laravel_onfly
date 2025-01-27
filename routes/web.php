<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Order\OrderController;

Route::get('/', function () {
    return Inertia::render('Order/Orders');
})->middleware(['auth', 'verified'])->name('orders');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/orders', [OrderController::class, 'index']);
Route::get('/orders/resume/{id}', [OrderController::class, 'show']);
Route::get('/orders/register', [OrderController::class, 'create']);

require __DIR__."/api.php";
require __DIR__."/auth.php";
