<?php

namespace App\Http\Controllers\Employee;

use App\Helpers\FilterHelper;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use App\Models\Employee\MasterEmployee;
use App\Http\Requests\Employee\StoreMasterEmployeeRequest;
use App\Http\Requests\Employee\UpdateMasterEmployeeRequest;
use Illuminate\Support\Facades\Gate;

class Master2dEmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // check for Gate Entry
        if (!Gate::allows('master_2d_employee_read')) {
            abort(401, "You are not Authorized to Access this Page !");
        }

        $designations = MasterEmployee::select('designation')->distinct()->pluck('designation');
        $organizations = MasterEmployee::select('organization')->distinct()->pluck('organization');

        $counts = MasterEmployee::select('designation', 'organization', DB::raw('count(*) as total'))
            ->groupBy('designation', 'organization')
            ->get()
            ->groupBy('designation')
            ->map(function ($items) {
                return $items->keyBy('organization');
            });

        return view(
            "employee.master-2d-employees.index",
            [
                'designations' => $designations,
                'organizations' => $organizations,
                'counts' => $counts
            ]
        );
    }

    public function matrixByDesignation(Request $request)
    {
        $designation = $request->designation;

        $organizations = MasterEmployee::where('designation', $designation)
            ->select('organization')
            ->distinct()
            ->pluck('organization');

        $departments = MasterEmployee::where('designation', $designation)
            ->select('department')
            ->distinct()
            ->pluck('department');

        $counts = MasterEmployee::where('designation', $designation)
            ->select('organization', 'department', DB::raw('count(*) as total'))
            ->groupBy('organization', 'department')
            ->get()
            ->groupBy('organization')
            ->map(function ($items) {
                return $items->keyBy('department');
            });

        return view('employee.master-2d-employees.matrix-by-designation', compact('designation', 'departments', 'organizations', 'counts'));
    }

    public function matrixByDesignationOrganization(Request $request)
    {
        $designation = $request->designation;
        $organization = $request->organization;

        $departments = MasterEmployee::where('designation', $designation)
            ->where('organization', $organization)
            ->select('department')
            ->distinct()
            ->pluck('department');

        $counts = MasterEmployee::where('designation', $designation)
            ->where('organization', $organization)
            ->select('department', DB::raw('count(*) as total'))
            ->groupBy('department')
            ->get()
            ->keyBy('department');

        $total = $counts->sum('total');

        return view('employee.master-2d-employees.matrix-by-designation-organization', compact(
            'designation',
            'organization',
            'departments',
            'counts',
            'total'
        ));

    }


    public function matrixByOrganization(Request $request)
    {
        $organization = $request->organization;

        $designations = MasterEmployee::where('organization', $organization)
            ->select('designation')
            ->distinct()
            ->pluck('designation');

        $departments = MasterEmployee::where('organization', $organization)
            ->select('department')
            ->distinct()
            ->pluck('department');

        $counts = MasterEmployee::where('organization', $organization)
            ->select('designation', 'department', DB::raw('count(*) as total'))
            ->groupBy('designation', 'department')
            ->get()
            ->groupBy('designation')
            ->map(function ($items) {
                return $items->keyBy('department');
            });

        return view('employee.master-2d-employees.matrix-by-organization', compact(
            'organization',
            'designations',
            'departments',
            'counts'
        ));
    }

    public function master2dEmployeeListing(Request $request)
    {
        // check for Gate Entry
        if (!Gate::allows('master_2d_employee_read')) {
            abort(401, "You are not Authorized to Access this Page !");
        }

        // filter helpers
        $related = [];
        $query = empty($related) ? MasterEmployee::query() : MasterEmployee::with($related);

        // for all designation
        if ($request->designation != null) {
            $query = $query->where('designation', '=', $request->designation);
        }

        // for all organization
        if ($request->organization != null) {
            $query = $query->where('organization', '=', $request->organization);
        }

        // for all department
        if ($request->department != null) {
            $query = $query->where('department', '=', $request->department);
        }

        // Apply filters
        $query = FilterHelper::apply($request, $query, $equals = [], $skips = []);

        // get records
        $records = $query->paginate(FilterHelper::rpp($request));
        // $records = $query->get();

        return view(
            "employee.master-2d-employees.master-2d-employee-listing",
            [
                'records' => $records,
                'filters' => FilterHelper::filters($request),
                'rpp' => FilterHelper::rpp($request),
                'department' => $request->department,
                'organization' => $request->organization,
                'designation' => $request->designation,
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
