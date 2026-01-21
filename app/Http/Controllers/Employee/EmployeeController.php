<?php

namespace App\Http\Controllers\Employee;

use App\Helpers\FilterHelper;
use App\Http\Controllers\Controller;
use App\Models\Employee\Employee;
use App\Http\Requests\Employee\StoreEmployeeRequest;
use App\Http\Requests\Employee\UpdateEmployeeRequest;
use App\Models\Location\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Authorize action if required
        if (!Gate::allows('admin_employee_read')) {
            abort(401, "You are not Authorized to Access this Page!");
        }

        // prepare query
        $related = [];
        $query = empty($related) ? Employee::query() : Employee::with($related);
        $query = FilterHelper::apply($request, $query, $equals = [], $skips = []);

        // get records
        $records = $query->paginate(FilterHelper::rpp($request));

        // get locations
        $locations = Location::getLocations('eUrjaFilter');

        return view(
            "admin.employees.index",
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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEmployeeRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        if (!Gate::allows('admin_employee_read')) {
            abort(401, "You are not Authorized to Access this Page!");
        }

        return view("admin.employees.index", $employee);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEmployeeRequest $request, Employee $employee)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        //
    }
}
