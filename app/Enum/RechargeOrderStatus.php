<?php

namespace App\Enum;

enum RechargeOrderStatus: string
{
    case PENDING = 'pending';
    case SUCCESS = 'success';
    case CANCELLED = 'cancelled';
    case FAILED = 'failed';
}
