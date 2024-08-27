<?php

namespace App\Models;


use App\Enum\TransferHistoryStatus;
use App\Models\Traits\HasBankingTransferQRCode;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

/**
 * App\Models\TransferHistory
 *
 * @property int $id
 * @property int $order_id
 * @property string $title
 * @property string $content
 * @property string $content_sign
 * @property array $metadata
 * @property TransferHistoryStatus $status
 * @property Carbon $received_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @method static Builder|static whereOrderId($value)
 * @method static Builder|static whereTitle($value)
 * @method static Builder|static whereContent($value)
 * @method static Builder|static whereContentSign($value)
 * @method static Builder|static whereStatus($value)
 * @method static Builder|static whereMetadata($value)
 * @method static Builder|static whereReceivedAt($value)
 * @method static Builder|static whereUpdatedAt($value)
 * @method static Builder|static whereCreatedAt($value)
*/
class TransferHistory extends PayModel
{
    use HasBankingTransferQRCode;

    protected $table = 'transfer_history';

    protected $fillable = [
        'order_id',
        'title',
        'content',
        'content_sign',
        'metadata',
        'status',
        'received_at',
    ];

    protected $casts = [
        'metadata' => 'array',
        'received_at' => 'datetime',
        'status' => TransferHistoryStatus::class,
    ];
}
