<?php

namespace App\Http\Controllers\Employee;

use App\Helpers\FilterHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee\MasterEmployee;
use App\Http\Requests\Employee\StoreMasterEmployeeRequest;
use App\Http\Requests\Employee\UpdateMasterEmployeeRequest;
use Illuminate\Support\Facades\Gate;

class MasterEmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // check for Gate Entry
        if (!Gate::allows('master_employee_read')) {
            abort(401, "You are not Authorized to Access this Page !");
        }

        // filter helpers
        $related = [];
        $query = empty($related) ? MasterEmployee::query() : MasterEmployee::with($related);

        // for class I and II Only
        // $query = $query->where(function ($q) {
        //     $q->where('class', '=', 'I')
        //         ->orWhere('class', '=', 'II');
        // });

        // Apply filters
        $query = FilterHelper::apply($request, $query, $equals = [], $skips = []);

        // get records
        $records = $query->paginate(FilterHelper::rpp($request));
        // $records = $query->get();

        return view(
            "employee.master-employees.index",
            [
                'records' => $records,
                'filters' => FilterHelper::filters($request),
                'rpp' => FilterHelper::rpp($request),
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
    public function store(StoreMasterEmployeeRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(MasterEmployee $masterEmployee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MasterEmployee $masterEmployee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMasterEmployeeRequest $request, MasterEmployee $masterEmployee)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MasterEmployee $masterEmployee)
    {
        //
    }
}
