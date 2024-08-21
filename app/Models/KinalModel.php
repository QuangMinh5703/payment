<?php

namespace App\Models;

use App\Contract\IKinalModel;
use App\Models\Traits\MuiQuery;
use App\Models\Traits\MultiplePrimaryKeys;
use App\Models\Traits\AutoTimestamps;
use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Expression;

abstract class KinalModel extends Model implements IKinalModel
{
    use AutoTimestamps, MuiQuery, MultiplePrimaryKeys;

    /**
     * Add a descending "order by" clause to the query.
     */
    public function scopeHighest(Builder $query, Builder|string|Closure|Expression|\Illuminate\Database\Query\Builder $column): Builder
    {
        return $query->orderByDesc($column);
    }
}
