<?php

namespace App\Http\Controllers\Emp\Request;

use App\Helpers\FilterHelper;
use App\Http\Controllers\Controller;
use App\Models\App\Request\Transfer;
use App\Http\Requests\Emp\Request\Transfer\StoreTransferRequest;
use App\Http\Requests\Emp\Request\Transfer\UpdateTransferRequest;
use App\Models\Employee\Employee;
use App\Models\Location\Location;
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
        if (!auth()->user()->can('emp_request_transfer_read')) {
            return redirect()->route('dashboard')
                ->withErrors(['You do not have permission to read the transfers.']);
        }

        // prepare query
        $related = ['preferences'];

        // base query
        $query = Transfer::query();

        // if admin or super admin then include trashed records
        if (auth()->user()->isAdminOrSuperAdmin()) {
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
            "emp.request.transfers.index",
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
        // Authorize
        if (!auth()->user()->can('emp_request_transfer_manage')) {
            return redirect()->route('dashboard')
                ->withErrors(['You do not have permission to create transfer requests.']);
        }

        // get logged users employee instance
        $employee = Employee::where('employee_number', auth()->user()->employee_number)->first();

        if (!$employee) {
            return redirect()->back()->with('error', 'Employee not found for logged in user.');
        }

        // Check if employee has existing active transfer request
        $existingTransfer = Transfer::where('employee_number', $employee->employee_number)
            ->where('is_expired', 0)
            ->whereNotNull('active_only')       // same result
            ->first();

        // Prevent user to create new request
        if ($existingTransfer) {
            return redirect()->route('emp.request.transfers.index', $existingTransfer->id)
                ->with('warning', 'You already have an active transfer request. You can update it using Update Request.');
        }

        // Get all locations except current location
        $locations = Location::where('id', '!=', $employee->location_id)
            ->orderBy('id')
            ->get()
            ->pluck('name', 'id');

        return view('emp.request.transfers.create', compact('employee', 'locations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTransferRequest $request)
    {
        // Get logged user
        $user = auth()->user();

        // Get logged users employee instance
        $employee = Employee::where('employee_number', $user->employee_number)->first();

        // Authorize
        if (!$user->can('emp_request_transfer_manage')) {
            return redirect()->route('dashboard')
                ->withErrors(['You do not have permission to create transfer requests.']);
        }

        // Get validated data
        $data = $request->validated();

        // Prepare data to be store into Transfer Entity
        $transferData = [
            'employee_number' => $employee['employee_number'],
            'current_location_id' => $employee->location->id,
            'current_department_id' => $employee->department->id,
            'current_designation_id' => $employee->designation->id,
            'native_place' => $data['native_place'],
            'current_place' => $data['current_place'],
            'is_spouse_case' => $data['is_spouse_case'],
            'spouse_employee_number' => $data['spouse_employee_number'] ?? null,
            'spouse_employee_location_id' => $data['spouse_employee_location_id'] ?? null,
            'reason' => $data['reason'] ?? null,
            'remarks' => $data['remarks'] ?? null,
            'location_1' => $data['location_1'],
            'location_2' => $data['location_2'],
            'location_3' => $data['location_3'],
        ];

        // Perform creation of transfer
        try {
            $transfer = Transfer::add($transferData);
        } catch (\Throwable $th) {
            report($th);
            return redirect()->back()->with('error', 'Failed to create transfer request' . $th->getMessage());
        }

        return redirect()->route('emp.request.transfers.index')->with('success', 'Request transfer created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Transfer $transfer)
    {
        //
        return view('emp.request.transfers.show', compact('transfer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transfer $transfer)
    {
        // 
        $transfer = $transfer->load('preferences', 'employee');

        // Get all locations except current location
        $locations = Location::where('id', '!=', $transfer->employee->location_id)
            ->orderBy('id')
            ->get()
            ->pluck('name', 'id');

        return view('emp.request.transfers.edit', compact('transfer', 'locations'));
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
