<?php

namespace App\Http\Controllers;

use App\BankNotificationProcessor;
use App\Enum\RechargeOrderStatus;
use App\Http\Request\BankNotificationRequest;
use App\Models\RechargeOrder;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function handleBankNotification(BankNotificationRequest $request)
    {
        $processor = new BankNotificationProcessor();
        $notification = $request->validated();
        $pendingOrders = RechargeOrder::where('status', 'pending')->get();
        foreach ($pendingOrders as $order) {
            // Chuyển đổi $notification thành string nếu cần
            $notificationString = is_array($notification) ? json_encode($notification) : $notification;

            $isValid = $processor->processNotification(
                $notificationString,
                $order->amount,
                $order->paymentMemo()
            );

            if ($isValid) {
                DB::transaction(function () use ($order) {
                    $order->update(['status' => RechargeOrderStatus::SUCCESS]);
                });
            }
        }

        return response()->noContent();
    }
}
