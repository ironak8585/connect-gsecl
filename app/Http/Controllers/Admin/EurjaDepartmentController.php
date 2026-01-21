<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\FilterHelper;
use App\Http\Controllers\Controller;
use App\Models\Admin\EurjaDepartment;
use App\Http\Requests\Admin\StoreEurjaDepartmentRequest;
use App\Http\Requests\Admin\UpdateEurjaDepartmentRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class EurjaDepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Authorize the user
        Gate::authorize('admin_eurja_departments_read');

        // prepare query
        $related = [];

        // base query
        $query = EurjaDepartment::query();

        // apply with()
        if (!empty($related)) {
            $query->with($related);
        }

        // Filter
        $query = FilterHelper::apply($request, $query, $equals = [], $skips = []);

        // get records
        $records = $query->paginate(FilterHelper::rpp($request));

        return view(
            "admin.eurja_departments.index",
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
    public function show(EurjaDepartment $eurjaDepartment)
    {
        // Authorize the user
        Gate::authorize('admin_eurja_departments_read');

        return view('admin.eurja_departments.show', compact('eurjaDepartment'));
    }

}
