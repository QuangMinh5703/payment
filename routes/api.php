<?php


use App\Http\Controllers\AuthController;
use App\Http\Controllers\RecharOrderController;
use Illuminate\Support\Facades\Route;

//Route::middleware('auth:sanctum')->group(function () {
    Route::post('recharge-order', [RecharOrderController::class, 'create']);
//});
Route::middleware('guest')->group(function () {
    Route::post('/login1', [AuthController::class, 'login'])->name('login');
});
Route::post('/logout1', [AuthController::class, 'logout'])->name('logout');
