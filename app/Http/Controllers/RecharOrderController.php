<?php

namespace App\Http\Controllers;

use App\Enum\PaymentMethodType;
use App\Enum\RechargeOrderStatus;
use App\Http\Request\RechargeOrderRequest;
use App\Models\PaymentMethod;
use App\Models\RechargeOrder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Request;

class RecharOrderController extends Controller
{
    public function create(RechargeOrderRequest $request) :JsonResponse
    {
        $data = $request->validated();
        $data['product_id'] = $request->getProductId();
        $data['user_id'] = 1;
        /**
         * @var RechargeOrder $order
        */
        $order = RechargeOrder::create($data);

        $response = [];
            $paymentMethod = PaymentMethod::where('type', PaymentMethodType::BANK_TRANSFER)->active()->inRandomOrder()->first();
            $response['data'] = [
                'qrData' => $order->qrCodeData(),
                'expiredAt' => $order->expired_at,
                'paymentAmount' => $order->amount,
                'paymentMemo' => $order->paymentMemo(),
                'paymentAccountName' => $paymentMethod->metadata['account_name'],
                'paymentAccountNumber' => $paymentMethod->metadata['account_number'],
            ];
        return response()->json($response);
    }
    public function cancel(Request $request, RechargeOrder $order): JsonResponse|Response
    {
        if ($order->status === RechargeOrderStatus::PENDING) {
            $order->update(['status' => RechargeOrderStatus::CANCELLED]);

            return response()->noContent();
        }

        if ($order->status === RechargeOrderStatus::CANCELLED) {
            return response()->noContent(200);
        }

        return response()->json(['message' => __('Lệnh nạp đã đã hết hạn hoặc có lỗi thanh toán.')], 400);
    }

    public function status(Request $request, RechargeOrder $order): JsonResponse
    {
        return response()->json([
            'status' => $order->status,
        ]);
    }
}
