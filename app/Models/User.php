<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;


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
class User extends PayModel
{
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
}
