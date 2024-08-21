<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

/**
 * @method static Builder|static muiQuery(?array $filterModel = null, ?array $sortModel = null)
 */
trait MuiQuery
{
    use Searchable;

    public function scopeMuiQuery(Builder $query, ?array $filterModel = null, ?array $sortModel = null)
    {
        if (is_null($filterModel)) {
            return $query;
        }

        if (! empty($filterModel['items'])) {
            $linkOperator = $filterModel['logicOperator'];
            foreach ($filterModel['items'] as $itemFilter) {
                $field = Str::snake($itemFilter['field']);
                if (! in_array($field, $this->getFillable())) {
                    continue;
                }
                $filterOperator = $itemFilter['operator'];
                if (empty($itemFilter['value'])) {
                    switch ($filterOperator) {
                        case 'isEmpty':
                            $whereFn = $linkOperator == 'or' ? 'orWhereNull' : 'whereNull';
                            $query = $query->{$whereFn}($field);
                            break;
                        case 'isNotEmpty':
                            $whereFn = $linkOperator == 'or' ? 'orWhereNotNull' : 'whereNotNull';
                            $query = $query->{$whereFn}($field);
                            break;
                    }

                    continue;
                }
                $whereFn = $linkOperator == 'or' ? 'orWhere' : 'where';
                $whereInFn = $linkOperator == 'or' ? 'orWhereIn' : 'whereIn';
                $whereDateFn = $linkOperator == 'or' ? 'orWhereDate' : 'whereDate';

                $filterValue = $itemFilter['value'];
                if (in_array($filterValue, ['true', 'false'])) {
                    $filterValue = filter_var($filterValue, FILTER_VALIDATE_BOOLEAN);
                }

                $query = match ($filterOperator) {
                    'startsWith' => $query->{$whereFn}($field, 'like', "%$filterValue"),
                    'endsWith' => $query->{$whereFn}($field, 'like', "$filterValue%"),
                    'contains' => $query->{$whereFn}($field, 'like', "%$filterValue%"),
                    'equals' => $query->{$whereFn}($field, '=', $filterValue),
                    'isAnyOf' => $query->{$whereInFn}($field, $filterValue),
                    'after' => $query->{$whereDateFn}($field, '<', $filterValue),
                    'onOrAfter' => $query->{$whereDateFn}($field, '<=', $filterValue),
                    'before' => $query->{$whereDateFn}($field, '>', $filterValue),
                    'onOrBefore' => $query->{$whereDateFn}($field, '>=', $filterValue),
                    'is' => $query->{$whereFn}($field, $filterValue),
                    default => $query->{$whereFn}($field, $filterOperator, $filterValue),
                };
            }
        }
        if (! empty($filterModel['quickFilterValues'])) {
            $searchText = implode(' ', $filterModel['quickFilterValues']);
            if (! empty($this->searchable)) {
                $query = $query->search($searchText);
            } else {
                $whereFn = $filterModel['quickFilterLogicOperator'] == 'or' ? 'orWhere' : 'where';
                $query = $query->{$whereFn}(function (Builder $query) use ($searchText, $filterModel) {
                    foreach ($filterModel['quickFilterCfg'] as $cfg) {
                        $field = $cfg['field'];
                        $operator = $cfg['operator'];
                        if (Str::contains($field, '.')) {
                            [$relationship, $column] = explode('.', $field);

                            $query->orWhereHas($relationship, function ($q) use ($operator, $column, $searchText) {

                                match ($operator) {
                                    'startsWith' => $q->where($column, 'like', "%$searchText"),
                                    'endsWith' => $q->where($column, 'like', "$searchText%"),
                                    'contains' => $q->where($column, 'like', "%$searchText%"),
                                    'equals' => $q->where($column, '=', $searchText),
                                    'isAnyOf' => $q->where($column, $searchText),
                                    default => is_numeric($searchText) && $q->where($column, $operator, $searchText),
                                };
                            });
                        } else {
                            match ($operator) {
                                'startsWith' => $query->orWhere($field, 'like', "%$searchText"),
                                'endsWith' => $query->orWhere($field, 'like', "$searchText%"),
                                'contains' => $query->orWhere($field, 'like', "%$searchText%"),
                                'equals' => $query->orWhere($field, '=', $searchText),
                                'isAnyOf' => $query->orWhereIn($field, $searchText),
                                default => is_numeric($searchText) && $query->orWhere($field, $operator, $searchText),
                            };
                        }
                    }
                });
            }
        }
        if (is_array($sortModel)) {
            foreach ($sortModel as $sort) {
                $field = Str::snake($sort['field']);
                if (! in_array($field, $this->getFillable())) {
                    continue;
                }
                $query = $query->orderBy($field, $sort['sort']);
            }
        }

        return $query;
    }
}
