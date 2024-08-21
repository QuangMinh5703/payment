<?php
/*
 * Copyright (c) 2022-2024. Kinal Games, Inc. All Rights Reserved.
 */

declare(strict_types=1);

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

/**
 * @method static Builder|static search(Builder $query, string $term)
 */
trait Searchable
{
    protected $searchable = [];

    protected $ftSearchMode = 'IN BOOLEAN MODE';

    protected function fullTextWildcards(string $term): string
    {
        $reservedSymbols = ['-', '+', '<', '>', '@', '(', ')', '~'];
        $term = str_replace($reservedSymbols, '', $term);
        $words = explode(' ', $term);
        foreach ($words as $key => $word) {
            if (strlen($word) >= 3) {
                $words[$key] = '+'.$word.'*';
            }
        }

        return implode(' ', $words);
    }

    protected function queryFullTextSearch(Builder $query, string $term, array $columns): Builder
    {
        $queryColumns = [];
        $term = $this->fullTextWildcards($term);
        foreach ($columns as $column) {
            if (Str::contains($column, '.')) {
                [$relationship, $column] = explode('.', $column);
                $query->orWhereHas($relationship, function (Builder $query) use ($column, $term) {
                    $query->whereRaw("MATCH ($column) AGAINST (? $this->ftSearchMode)", $term);
                });
            } else {
                $queryColumns[] = $column;
            }
        }

        $queryColumns = implode(',', $queryColumns);

        return $query->orWhereRaw("MATCH ($queryColumns) AGAINST (? $this->ftSearchMode)", $term);
    }

    public function scopeSearch(Builder $query, string $term): Builder
    {
        if (strlen($term) >= 3) {
            return $this->queryFullTextSearch($query, $term, $this->searchable);
        }
        foreach ($this->searchable as $column) {
            if (Str::contains($column, '.')) {
                [$relationship, $column] = explode('.', $column);
                $query->orWhereHas($relationship, function (Builder $query) use ($column, $term) {
                    $columns = explode(',', $column);
                    foreach ($columns as $column) {
                        $query->orWhere($column, 'LIKE', '%'.$term.'%');
                    }
                });
            } else {
                $query->orWhere($column, 'LIKE', '%'.$term.'%');
            }
        }

        return $query;
    }
}
