<?php

namespace App\Http\Controllers\Web\Request;

use App\Helpers\FilterHelper;
use App\Http\Controllers\Controller;
use App\Models\App\Request\Transfer;
use Illuminate\Http\Request;

class TransferController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     * @param \Illuminate\Http\Request $request
     */
    public function index(Request $request)
    {
        // prepare query
        $related = ['preferences', 'employee', 'currentLocation', 'currentDepartment', 'currentDesignation'];

        // base query
        $query = Transfer::query();

        // apply with()
        if (!empty($related)) {
            $query->with($related);
        }

        // Filter
        $query = FilterHelper::apply($request, $query, $equals = [], $skips = []);

        // get records
        $records = $query->paginate(FilterHelper::rpp($request));

        return view(
            "web.request.transfers.index",
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
    public function show(Transfer $transfer)
    {
        //
        $transfer->load(['employee', 'currentLocation', 'currentDepartment', 'CurrentDesignation', 'spouseEmployee', 'spouseEmployeeLocation', 'hodApproverEmployee', 'pscApproverEmployee', 'preferences']);

        // dd($transfer, $transfer->employee, $transfer->employee->department, $transfer->currentDepartment);

        return view("web.request.transfers.show", compact('transfer'));
    }

}
