<?php

namespace App\Contract;

interface ITransferPay
{
    public function paymentMemoForOrder(): string;
}
