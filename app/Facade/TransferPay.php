<?php

namespace App\Facade;

use App\Contract\ITransferPay;
use Illuminate\Support\Facades\Facade;

/**
 * @mixin ITransferPay
 *
 * @see \App\TransferPay
 */
class TransferPay extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'kg.payment.transfer';
    }
}
