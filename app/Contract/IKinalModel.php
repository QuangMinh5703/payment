<?php

namespace App\Contract;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Expression;

/**
 * @method static Builder|static highest(Builder|string|Closure|Expression|\Illuminate\Database\Query\Builder $columns)
 * @method static Builder|static newModelQuery()
 * @method static Builder|static newQuery()
 * @method static Builder|static query()
 *
 * @mixin Model
 * @mixin Builder
 */
interface IKinalModel
{
    public function scopeHighest(Builder $query, Builder|string|Closure|Expression|\Illuminate\Database\Query\Builder $column): Builder;
}
