<?php

namespace App\Models;

use App\Enum\PaymentMethodStatus;
use App\Enum\PaymentMethodType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

/**
 * App\Models\PaymentMethod
 *
 * @property int $id
 * @property PaymentMethodType $type
 * @property string $code
 * @property string $name
 * @property string|null $description Use to write recharge instructions
 * @property PaymentMethodStatus $status
 * @property array|null $metadata
 * @property float $exchange_rate
 * @property Carbon|null $closed_at
 * @property Carbon|null $last_maintenance_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @method static Builder|static active()
 * @method static Builder|static whereId($value)
 * @method static Builder|static whereType($value)
 * @method static Builder|static whereCode($value)
 * @method static Builder|static whereName($value)
 * @method static Builder|static whereDescription($value)
 * @method static Builder|static whereStatus($value)
 * @method static Builder|static whereExchangeRate($value)
 * @method static Builder|static whereClosedAt($value)
 * @method static Builder|static whereLastMaintenanceAt($value)
 * @method static Builder|static whereCreatedAt($value)
 * @method static Builder|static whereUpdatedAt($value)
*/
class PaymentMethod extends PayModel
{
    protected $table = 'payment_method';

    protected $fillable = [
        'type',
        'code',
        'description',
        'status',
        'metadata',
        'closed_at',
        'last_maintenance_at'
    ];

    protected $casts = [
        'exchange_rate' => 'float',
        'closed_at' => 'datetime',
        'last_maintenance_at' => 'datetime',
        'metadata' => 'array',
        'status' => PaymentMethodStatus::class,
        'type' => PaymentMethodType::class,
    ];

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', PaymentMethodStatus::ACTIVE);
    }
}
