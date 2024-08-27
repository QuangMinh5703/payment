<?php

namespace App\Http\Controllers;

use App\Enum\PaymentMethodType;
use App\Http\Request\RechargeOrderRequest;
use App\Models\PaymentMethod;
use App\Models\RechargeOrder;
use Illuminate\Http\JsonResponse;

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
                'paymentAccountName' => $paymentMethod->metadata['account_name'],
                'paymentAccountNumber' => $paymentMethod->metadata['account_number'],
            ];
        return response()->json($response);
    }
}
