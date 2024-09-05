<?php

namespace App;

use App\Contract\ITransferPay;
use App\Models\RechargeOrder;


final class TransferPay implements ITransferPay
{
    public function paymentMemoForOrder(RechargeOrder $order): string
    {
        // Lấy tx_id của order
        $txId = $order->tx_id;

        // Ví dụ, lấy tối đa 10 ký tự từ txId
        $shortTxId = substr($txId, 4, 14);

        return $shortTxId;
    }
}
