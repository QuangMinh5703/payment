<?php

namespace App\Models;

use App\Enum\PaymentMethodStatus;
use App\Enum\PaymentMethodType;
use App\Enum\RechargeOrderStatus;
use App\Facade\TransferPay;
use App\Models\Traits\HasBankingTransferQRCode;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;


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
 * @property string $tx_id
 * @property Carbon|null $expired_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @method static Builder|static wherePaymentMethod($value)
 * @method static Builder|static whereUserId($value)
 * @method static Builder|static whereTxId($value)
*/
class RechargeOrder extends PayModel
{
    use HasBankingTransferQRCode;

    protected $table = 'recharge_order';

    protected $fillable = [
        'user_id',
        'product_id',
        'payment_method',
        'amount',
        'status',
        'payload',
        'tx_id',
        'expired_at'
    ];

    protected $casts = [
        'payment_method' => PaymentMethodType::class,
        'status' => RechargeOrderStatus::class,
        'expired_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (self $transaction) {
            $transaction->tx_id = static::generateUniqueOrderId();
            $transaction->expired_at = now()->addMinutes(config('kg-payment.game_recharge.order_expired_minutes'));
        });
    }

    public static function generateUniqueOrderId(): string
    {
        $timestamp = now()->format('ymdHi'); // 2 chữ số cuối của năm + tháng + ngày + giờ + phút
        $random = Str::upper(Str::random(4)); // 4 ký tự ngẫu nhiên in hoa

        $orderIdFormat = $timestamp.$random;

        // Kiểm tra xem order_id đã tồn tại chưa
        while (static::whereTxId($orderIdFormat)->exists()) {
            $random = Str::upper(Str::random(4));
            $orderIdFormat = $timestamp.$random;
        }

        return $orderIdFormat;
    }

    public function qrCodeData(): ?string
    {
        if ($this->payment_method == PaymentMethodType::BANK_TRANSFER) {
            $paymentMethod = PaymentMethod::where('type', PaymentMethodType::BANK_TRANSFER)->active()->inRandomOrder()->first();
            $amount = $this['amount'];

            return $this->generateQRCodeData($paymentMethod->metadata['bank_id'], $paymentMethod->metadata['account_number'], TransferPay::paymentMemoForOrder($this), amount: $amount);
        }

        return null;
    }

    public function paymentMemo(): string
    {
        return TransferPay::paymentMemoForOrder($this);
    }
}
