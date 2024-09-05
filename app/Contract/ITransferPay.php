<?php

namespace App\Contract;

use App\Models\RechargeOrder;

interface ITransferPay
{
    public function paymentMemoForOrder(RechargeOrder $order): string;
}
