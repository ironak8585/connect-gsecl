<?php

namespace App\Http\Controllers\Emp\Request;

use App\Helpers\FilterHelper;
use App\Http\Controllers\Controller;
use App\Models\App\Request\Transfer;
use App\Http\Requests\Emp\Request\Transfer\StoreTransferRequest;
use App\Http\Requests\App\Request\Transfer\UpdateTransferRequest;
use App\Models\App\Request\TransferPreference;
use App\Models\App\Request\TransferPreferencesHistory;
use App\Models\Employee\Employee;
use App\Models\Employee\MasterEmployee;
use App\Models\Location\Location;
use Auth;
use DB;
use Log;
use Illuminate\Http\Request;

class BKP_TransferController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     * @param \Illuminate\Http\Request $request
     */
    public function index(Request $request)
    {
        dd("test");

        // // Authorize the User
        // if (!auth()->user()->can('emp_request_transfer_manage')) {
        //     return redirect()->route('dashboard')
        //         ->withErrors(['You do not have permission to view the requests.']);
        // }

        // prepare query
        $related = ['employee', 'currentLocation', 'currentDepartment', 'activePreferences.location'];

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

        $employee = Employee::where('employee_number', Auth::user()->employee_number)->first();

        if (!$employee) {
            return redirect()->back()->with('error', 'Employee record not found.');
        }

        // Check if employee has existing active transfer request
        $existingTransfer = Transfer::where('employee_number', $employee->employee_number)
            ->whereIn('status', ['draft', 'requested'])
            ->first();

        if ($existingTransfer) {
            return redirect()->route('emp.request.transfers.show', $existingTransfer->id)
                ->with('warning', 'You already have an active transfer request. You can update it below.');
        }

        // Get all locations except current location
        $locations = Location::where('id', '!=', $employee->location_id)
            ->orderBy('name')
            ->get();

        // Get previously transferred locations to exclude from dropdown
        $transferredLocations = DB::table('transfer_operations')
            ->where('employee_number', $employee->employee_number)
            ->pluck('to_location_id')
            ->toArray();

        // Filter out transferred locations from available choices
        $availableLocations = $locations->whereNotIn('id', $transferredLocations);

        return view('emp.request.transfers.create', compact(
            'employee',
            'availableLocations',
            'existingTransfer',
            'transferredLocations'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTransferRequest $request)
    {
        // ISSUE #1 FIXED: Don't repeat validation - StoreTransferRequest already handles it
        // All validation is done in the Form Request class

        // Get validated data with employee information
        $validated = $request->validatedWithEmployee();

        DB::beginTransaction();
        try {
            // ISSUE #2 FIXED: No need to check again - Form Request already checked
            // The Form Request validation ensures no active transfer exists

            // Create new transfer request
            $transfer = Transfer::create([
                'employee_number' => $validated['employee_number'],
                'current_location_id' => $validated['current_location_id'],
                'current_department_id' => $validated['current_department_id'],
                'reason' => $validated['reason'],
                'renewal_year' => date('Y'),
                'last_renewed_at' => now(),
                'renewal_due_date' => date('Y') . '-12-31',
                'is_renewed' => true,
                'status' => 'requested',
                // ISSUE #3 FIXED: Don't manually set created_by/updated_by - Userstamps handles it
            ]);

            Log::info('Transfer created successfully', ['transfer_id' => $transfer->id]);

            // Create preferences
            $preferences = [
                ['location_id' => $validated['preference_1'], 'preference' => 1],
                ['location_id' => $validated['preference_2'], 'preference' => 2],
                ['location_id' => $validated['preference_3'], 'preference' => 3],
            ];

            foreach ($preferences as $pref) {
                // ISSUE #4 FIXED: Removed unnecessary try-catch inside loop
                $preference = TransferPreference::create([
                    'transfer_id' => $transfer->id,
                    'location_id' => $pref['location_id'],
                    'preference' => $pref['preference'],
                    'request_type' => 'fresh',
                    'is_active' => true,
                    // ISSUE #3 FIXED: Don't manually set created_by/updated_by
                ]);

                Log::info('Preference created', [
                    'transfer_id' => $transfer->id,
                    'preference' => $pref['preference'],
                    'location_id' => $pref['location_id']
                ]);

                // Log to history
                TransferPreferencesHistory::create([
                    'transfer_id' => $transfer->id,
                    'transfer_preference_id' => $preference->id,
                    'location_id' => $pref['location_id'],
                    'preference' => $pref['preference'],
                    'action_type' => 'created',
                    'request_type' => 'fresh',
                    // ISSUE #3 FIXED: Don't manually set created_by/updated_by
                ]);

                Log::info('Preference history created', [
                    'transfer_id' => $transfer->id,
                    'preference_id' => $preference->id
                ]);
            }

            DB::commit();

            Log::info('Transfer request submitted successfully', ['transfer_id' => $transfer->id]);

            return redirect()->route('emp.request.transfers.show', $transfer->id)
                ->with('success', 'Transfer request submitted successfully.');

        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();

            // Log detailed database error
            Log::error('Database error during transfer creation', [
                'message' => $e->getMessage(),
                'sql' => $e->getSql(),
                'bindings' => $e->getBindings(),
                'trace' => $e->getTraceAsString()
            ]);

            // ISSUE #5 FIXED: Better error messages for debugging
            if (config('app.debug')) {
                return redirect()->back()
                    ->with('error', 'Database Error: ' . $e->getMessage())
                    ->withInput();
            }

            return redirect()->back()
                ->with('error', 'Failed to submit transfer request due to a database error. Please contact support.')
                ->withInput();

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Transfer creation failed', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            // ISSUE #5 FIXED: Show actual error in debug mode
            if (config('app.debug')) {
                return redirect()->back()
                    ->with('error', 'Error: ' . $e->getMessage() . ' in ' . $e->getFile() . ' on line ' . $e->getLine())
                    ->withInput();
            }

            return redirect()->back()
                ->with('error', 'Failed to submit transfer request. Please try again or contact support.')
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Transfer $transfer)
    {
        // Authorize - user can only view their own transfer
        if (
            $transfer->employee_number !== Auth::user()->employee_number
            && !auth()->user()->can('emp_request_transfer_manage')
        ) {
            return redirect()->route('emp.request.transfers.index')
                ->withErrors(['You do not have permission to view this transfer request.']);
        }

        // Load relationships
        $transfer->load([
            'employee',
            'currentLocation',
            'currentDepartment',
            'activePreferences.location',
            'preferencesHistory.location',
            'hodApprover',
            'pscApprover'
        ]);

        return view('emp.request.transfers.show', compact('transfer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transfer $transfer)
    {
        // Authorize - user can only edit their own transfer
        if ($transfer->employee_number !== Auth::user()->employee_number) {
            return redirect()->route('emp.request.transfers.index')
                ->withErrors(['You do not have permission to edit this transfer request.']);
        }

        // Check if transfer can be edited
        if (!$transfer->canBeUpdated()) {
            return redirect()->route('emp.request.transfers.show', $transfer->id)
                ->withErrors(['This transfer request cannot be edited in its current status.']);
        }

        $employee = $transfer->employee;

        // Get all locations except current location
        $locations = Location::where('id', '!=', $employee->location_id)
            ->orderBy('name')
            ->get();

        // Get previously transferred locations to exclude from dropdown
        $transferredLocations = DB::table('transfer_operations')
            ->where('employee_number', $employee->employee_number)
            ->pluck('to_location_id')
            ->toArray();

        // Filter out transferred locations from available choices
        $availableLocations = $locations->whereNotIn('id', $transferredLocations);

        // Get current preferences
        $currentPreferences = $transfer->activePreferences()
            ->orderBy('preference')
            ->get()
            ->pluck('location_id', 'preference')
            ->toArray();

        return view('emp.request.transfers.edit', compact(
            'transfer',
            'employee',
            'availableLocations',
            'transferredLocations',
            'currentPreferences'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTransferRequest $request, Transfer $transfer)
    {
        // Authorization and validation handled by UpdateTransferRequest
        $validated = $request->validated();

        DB::beginTransaction();
        try {
            // Update transfer reason
            $transfer->update([
                'reason' => $validated['reason'],
            ]);

            Log::info('Transfer updated', ['transfer_id' => $transfer->id]);

            // Mark old preferences as inactive
            $transfer->preferences()->update(['is_active' => false]);

            // Create new preferences
            $preferences = [
                ['location_id' => $validated['preference_1'], 'preference' => 1],
                ['location_id' => $validated['preference_2'], 'preference' => 2],
                ['location_id' => $validated['preference_3'], 'preference' => 3],
            ];

            foreach ($preferences as $pref) {
                $preference = TransferPreference::create([
                    'transfer_id' => $transfer->id,
                    'location_id' => $pref['location_id'],
                    'preference' => $pref['preference'],
                    'request_type' => 'updated',
                    'is_active' => true,
                ]);

                // Log to history
                TransferPreferencesHistory::create([
                    'transfer_id' => $transfer->id,
                    'transfer_preference_id' => $preference->id,
                    'location_id' => $pref['location_id'],
                    'preference' => $pref['preference'],
                    'action_type' => 'updated',
                    'request_type' => 'updated',
                ]);

                Log::info('Preference updated', [
                    'transfer_id' => $transfer->id,
                    'preference' => $pref['preference']
                ]);
            }

            DB::commit();

            return redirect()->route('emp.request.transfers.show', $transfer->id)
                ->with('success', 'Transfer request updated successfully.');

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Transfer update failed', [
                'transfer_id' => $transfer->id,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            if (config('app.debug')) {
                return redirect()->back()
                    ->with('error', 'Error: ' . $e->getMessage())
                    ->withInput();
            }

            return redirect()->back()
                ->with('error', 'Failed to update transfer request. Please try again.')
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transfer $transfer)
    {
        // Authorize - user can only delete their own transfer
        if (
            $transfer->employee_number !== Auth::user()->employee_number
            && !auth()->user()->can('emp_request_transfer_delete')
        ) {
            return redirect()->route('emp.request.transfers.index')
                ->withErrors(['You do not have permission to delete this transfer request.']);
        }

        // Check if transfer can be deleted
        if (!in_array($transfer->status, ['draft', 'requested'])) {
            return redirect()->route('emp.request.transfers.show', $transfer->id)
                ->withErrors(['This transfer request cannot be deleted in its current status.']);
        }

        DB::beginTransaction();
        try {
            $transfer->delete();

            DB::commit();

            Log::info('Transfer deleted', [
                'transfer_id' => $transfer->id,
                'employee_number' => $transfer->employee_number
            ]);

            return redirect()->route('emp.request.transfers.index')
                ->with('success', 'Transfer request deleted successfully.');

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Transfer deletion failed', [
                'transfer_id' => $transfer->id,
                'message' => $e->getMessage()
            ]);

            return redirect()->back()
                ->with('error', 'Failed to delete transfer request. Please try again.');
        }
    }

    /**
     * Cancel the transfer request
     */
    public function cancel(Transfer $transfer)
    {
        // Authorize - user can only cancel their own transfer
        if ($transfer->employee_number !== Auth::user()->employee_number) {
            return redirect()->route('emp.request.transfers.index')
                ->withErrors(['You do not have permission to cancel this transfer request.']);
        }

        // Check if transfer can be cancelled
        if (!in_array($transfer->status, ['draft', 'requested'])) {
            return redirect()->route('emp.request.transfers.show', $transfer->id)
                ->withErrors(['This transfer request cannot be cancelled in its current status.']);
        }

        DB::beginTransaction();
        try {
            $transfer->update([
                'status' => 'cancelled',
                'cancelled_at' => now(),
                'cancellation_reason' => 'Cancelled by employee',
            ]);

            // Mark preferences as inactive
            $transfer->preferences()->update(['is_active' => false]);

            // Log to history
            TransferPreferencesHistory::create([
                'transfer_id' => $transfer->id,
                'transfer_preference_id' => null,
                'location_id' => null,
                'preference' => null,
                'action_type' => 'cancelled',
                'request_type' => null,
                'cancelled_at' => now(),
                'remarks' => 'Cancelled by employee',
            ]);

            DB::commit();

            Log::info('Transfer cancelled', [
                'transfer_id' => $transfer->id,
                'employee_number' => $transfer->employee_number
            ]);

            return redirect()->route('emp.request.transfers.index')
                ->with('success', 'Transfer request cancelled successfully.');

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Transfer cancellation failed', [
                'transfer_id' => $transfer->id,
                'message' => $e->getMessage()
            ]);

            return redirect()->back()
                ->with('error', 'Failed to cancel transfer request. Please try again.');
        }
    }
}