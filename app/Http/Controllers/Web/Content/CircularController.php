<?php

namespace App\Http\Controllers\Web\Content;

use App\Helpers\FilterHelper;
use App\Http\Controllers\Controller;
use App\Models\App\Content\Circular;
use Illuminate\Http\Request;

class CircularController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        // prepare query
        $related = []; 

        // base query
        $query = Circular::query();

        // apply with()
        if (!empty($related)) {
            $query->with($related);
        }

        // Filter
        $query = FilterHelper::apply($request, $query, $equals = [], $skips = []);

        // get records
        $records = $query->paginate(FilterHelper::rpp($request));

        return view(
            "web.content.circulars.index",
            [
                'records' => $records,
                'filters' => FilterHelper::filters($request),
                'rpp' => FilterHelper::rpp($request)
            ]
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Circular $circular)
    {
        //
        return view('web.content.circulars.show', compact('circular'));
    }
}
