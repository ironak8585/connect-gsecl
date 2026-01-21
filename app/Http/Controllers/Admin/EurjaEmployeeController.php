<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\FilterHelper;
use App\Http\Controllers\Controller;
use App\Models\Admin\EurjaEmployee;
use App\Http\Requests\Admin\StoreEurjaEmployeeRequest;
use App\Http\Requests\Admin\UpdateEurjaEmployeeRequest;
use App\Models\Location\Location;
use Gate;
use Illuminate\Http\Request;

class EurjaEmployeeController extends Controller
{
    /**
     * Display the listing of resources
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Authorize action if required
        if (!Gate::allows('admin_eurja_employee_read')) {
            abort(401, "You are not Authorized to Access this Page!");
        }

        // prepare query
        $related = [];
        $query = empty($related) ? EurjaEmployee::query() : EurjaEmployee::with($related);
        $query = FilterHelper::apply($request, $query, $equals = [], $skips = []);

        // get records
        $records = $query->paginate(FilterHelper::rpp($request));

        // get locations
        $locations = Location::getLocations('eUrjaFilter');

        return view(
            "admin.eurja-employees.index",
            [
                'records' => $records,
                'filters' => FilterHelper::filters($request),
                'rpp' => FilterHelper::rpp($request),
                'locations' => $locations
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function sync(Request $request)
    {
        // Authorize action if required
        if (!Gate::allows('admin_eurja_employee_sync')) {
            abort(401, "You are not Authorized to Access this Page!");
        }

        // Sync the eUrja Data
        try {
            EurjaEmployee::sync();
        } catch (\Throwable $th) {
            throw $th;
            // return back()->withErrors(['Error in Synchronization of Employee with eUrja', $th->getMessage()]);
        }

        return redirect()->route('admin.eurja-employees.index')->with('success', 'Synchronization successfully completed');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEurjaEmployeeRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(EurjaEmployee $eurjaEmployee)
    {
        // Authorize action if required
        if (!Gate::allows('admin_eurja_employee_read')) {
            abort(401, "You do not have permission to read the eUrja Employee !");
        }

        return view("admin.eurja-employees.show", ['employee' => $eurjaEmployee]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EurjaEmployee $eurjaEmployee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEurjaEmployeeRequest $request, EurjaEmployee $eurjaEmployee)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EurjaEmployee $eurjaEmployee)
    {
        //
    }
}
