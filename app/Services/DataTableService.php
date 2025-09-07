<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DataTableService
{
    /**
     * Handle DataTable server-side processing.
     *
     * @param  Request  $request
     * @param  Builder  $query
     * @param  array    $columns
     * @param  array    $customColumns
     * @return array
     */
    public function handle(Request $request, Builder $query, array $columns, array $customColumns = [])
    {
        $draw   = $request->input('draw');
        $start  = $request->input('start');
        $length = $request->input('length');

        // Count total records
        $totalRecords = $query->count();

        // Clone for filtering
        $filteredQuery = clone $query;

        // Searching
        if ($searchValue = $request->input('search.value')) {
            $filteredQuery->where(function ($q) use ($searchValue, $columns) {
                foreach ($columns as $col) {
                    if (str_contains($col, '.')) {
                        // Handle relation columns (e.g. role.name)
                        [$relation, $field] = explode('.', $col);
                        $q->orWhereHas($relation, function ($sub) use ($field, $searchValue) {
                            $sub->where($field, 'LIKE', "%{$searchValue}%");
                        });
                    } else {
                        // Handle normal + aliased columns
                        $q->orWhere($col, 'LIKE', "%{$searchValue}%");
                    }
                }
            });
        }

        // Count filtered records
        $totalFiltered = $filteredQuery->count();

        // Sorting
        if ($order = $request->input('order.0')) {
            $colIndex = $order['column'];
            $dir = $order['dir'];
            $orderCol = $columns[$colIndex] ?? null;

            if ($orderCol) {
                if (str_contains($orderCol, '.')) {
                    // Skip relation sorting (too complex without join)
                } else {
                    $filteredQuery->orderBy($orderCol, $dir);
                }
            }
        }

        // Pagination
        $records = $filteredQuery->skip($start)->take($length)->get();

        // Prepare response data
        $data = $records->map(function ($row) use ($columns, $customColumns) {
            $record = [];

            foreach ($columns as $col) {
                if (str_contains($col, '.')) {
                    // Relation field
                    [$relation, $field] = explode('.', $col);
                    $value = optional($row->$relation)->$field;
                } else {
                    // Normal or alias field
                    $value = $row->$col ?? $row->{$this->aliasToCamel($col)};
                }

                // Format if it's a Carbon date
                if ($value instanceof Carbon) {
                    if ($value->format('H:i:s') === '00:00:00') {
                        // Date only
                        $value = $value->toDateString(); // Y-m-d
                    } else {
                        // Full datetime
                        $value = $value->format('Y-m-d h:i:s');
                    }
                }

                $record[$col] = $value;
            }

            // Custom computed columns
            foreach ($customColumns as $key => $callback) {
                $record[$key] = $callback($row);
            }

            return $record;
        });

        return [
            'draw' => intval($draw),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalFiltered,
            'data' => $data,
        ];
    }

    /**
     * Convert alias with underscore to camelCase (optional fallback).
     */
    private function aliasToCamel($alias)
    {
        return lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $alias))));
    }
}
