<?php

namespace App\Helpers;

use App\Models\Master\Configuration;
use Illuminate\Http\Request;

class FilterHelper
{
    /**
     * Apply filter to query using request paramters
     *
     * @param \Illuminate\Http\Request  $request
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param array $equals
     * @param array $skips
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function apply(Request $request, $query, $equals = [], $skips = [])
    {
        foreach ($request->all() as $key => $value) {
            if (in_array($key, ['page', 'rpp'])) {
                continue;
            }
            if (in_array($key, $skips)) {
                continue;
            }
            if (in_array($key, $equals)) {
                $query = $query->where($key, $value);
            } else {
                $query = $query->where($key, 'LIKE', '%' . $value . '%');
            }
        }
        return $query;
    }

    public static function rpp(Request $request)
    {
        if ($request->has('rpp') && $request->rpp != 'undefined') {
            return $request->rpp;
        } else {
            // return Configuration::getValue('RECORDS_PER_PAGE');
            return 10;
        }
    }

    public static function filters(Request $request)
    {
        return $request->except(['rpp', 'page']);
    }
}
