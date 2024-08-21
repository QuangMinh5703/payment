<?php

namespace App\Facade;


use App\Contract\IPayment;

/**
 * @mixin IPayment
 * @see \App\Payment
 */
class Payment
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'kg.payment';
    }
}
