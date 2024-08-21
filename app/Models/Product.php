<?php

namespace App\Models;

use App\Enum\ProductCode;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

/**
 * App\Model\Product
 *
 * @property int $id
 * @property ProductCode $code
 * @property string $name
 * @property string $description
 * @property array|null $metadata
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 *
 * @method static Builder|static whereCode($value)
 * @method static Builder|static whereName($value)
 * @method static Builder|static whereDescription($value)
 */
class Product extends PayModel
{
    protected $table = 'product';

    protected $fillable = [
        'code',
        'name',
        'description',
        'metadata'
    ];

    protected $casts = [
        'code' => ProductCode::class,
        'metadata' => 'array',
    ];

    protected $searchable = [
        'name',
        'description',
    ];
}
