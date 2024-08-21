<?php

namespace App\Models;

use App\Enum\PaymentMethodStatus;
use App\Enum\RechargeOrderStatus;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

/**
 * App\Models\RechargeOrder
 *
 * @property int $id
 * @property int $user_id
 * @property int $product_id
 * @property PaymentMethodStatus $payment_method
 * @property int $amount
 * @property RechargeOrderStatus $status
 * @property string|null $payload
 * @property Carbon|null $expired_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @method static Builder|static wherePaymentMethod($value)
 * @method static Builder|static whereUserId($value)
*/
class RechargeOrder extends PayModel
{
    protected $table = 'recharge_order';

    protected $fillable = [
        'user_id',
        'product_id',
        'payment_method',
        'amount',
        'status',
        'payload',
        'expired_at'
    ];

    protected $casts = [
        'payment_method' => PaymentMethodStatus::class,
        'status' => RechargeOrderStatus::class,
        'expired_at' => 'datetime',
    ];

}
