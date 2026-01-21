<?php

namespace App\Http\Controllers\App\Request;

use App\Helpers\FilterHelper;
use App\Http\Controllers\Controller;
use App\Models\App\Request\Transfer;
use App\Http\Requests\App\Request\Transfer\StoreTransferRequest;
use App\Http\Requests\App\Request\Transfer\UpdateTransferRequest;
use Auth;
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
        // Authorize the User
        if (!auth()->user()->can('app_content_circular_manage')) {
            return redirect()->route('app.content.circulars.index')
                ->withErrors(['You do not have permission to delete circular.']);
        }

        // prepare query
        $related = []; 

        // base query
        $query = Transfer::query();

        // if admin or super admin then include trashed records
        if (Auth::user()->isAdminOrSuperAdmin()) {
            $query->withTrashed();
        }

        // apply with()
        if (!empty($related)) {
            $query->with($related);
        }

        // Filter
        $query = FilterHelper::apply($request, $query, $equals = [], $skips = []);

        // get records
        $records = $query->paginate(FilterHelper::rpp($request));

        return view(
            "app.request.transfers.index",
            [
                'records' => $records,
                'filters' => FilterHelper::filters($request),
                'rpp' => FilterHelper::rpp($request)
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
    public function store(StoreTransferRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Transfer $transfer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transfer $transfer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTransferRequest $request, Transfer $transfer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transfer $transfer)
    {
        //
    }
}
