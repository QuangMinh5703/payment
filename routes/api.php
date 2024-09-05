<?php


use App\Http\Controllers\AuthController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\RecharOrderController;
use Illuminate\Support\Facades\Route;
//
//Route::middleware('auth:sanctum')
//    ->name('game')
//    ->group(function () {
    Route::post('recharge-order/create', [RecharOrderController::class, 'create']);
    Route::post('recharge-order/{order}/cancel', [RecharOrderController::class, 'cancel']);
    Route::post('recharge-order/{order}/status', [RecharOrderController::class, 'status']);
//});
Route::post('check-notification',[PaymentController::class, 'handleBankNotification']);
Route::middleware('guest')->group(function () {
    Route::post('/login1', [AuthController::class, 'login'])->name('login');
});
Route::post('/logout1', [AuthController::class, 'logout'])->name('logout');
