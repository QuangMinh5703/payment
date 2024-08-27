<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Sanctum\HasApiTokens;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 *
 * @method static Builder|static whereId($value)
 * @method static Builder|static whereName($value)
 * @method static Builder|static whereEmail($value)
*/
class User extends PayModel implements Authenticatable
{
    use HasFactory,HasApiTokens;
    use \Illuminate\Auth\Authenticatable;

    protected $table = 'user';

    protected $fillable = [
        'name',
        'email',
        'password'
    ];

    protected $hidden = [
      'password',
    ];

    protected $searchable = [
      'name',
      'email'
    ];

    public function RechargeOrder(): HasMany
    {
        return $this->hasMany(RechargeOrder::class);
    }
}
