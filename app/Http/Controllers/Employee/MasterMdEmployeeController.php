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

class MasterMdEmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // check for Gate Entry
        if (!Gate::allows('master_md_employee_read')) {
            abort(401, "You are not Authorized to Access this Page !");
        }

        // get all distinct designations from MasterEmployee
        $organizations = MasterEmployee::select('organization')
            ->distinct()
            ->orderBy('organization', 'asc')
            ->pluck('organization');

        $coreDepartments = MasterEmployee::select('core_department')
            ->whereNotNull('core_department')
            ->where('core_department', '!=', '')
            ->distinct()
            ->orderBy('core_department', 'asc')
            ->pluck('core_department');

        $designationsList = MasterEmployee::select('designation')
            ->whereNotNull('designation')
            ->where('designation', '!=', '')
            ->distinct()
            // ->orderBy('designation_level', 'asc')
            ->pluck('designation');

        $orgShortName = array_map(function ($name) {
            // Split into words, take first letter of each, uppercase, and join
            return strtoupper(implode('', array_map(fn($word) => $word[0], preg_split('/\s+/', $name))));
        }, $organizations->toArray());

        $designations = MasterEmployee::select(
            'designation',
            'organization',
            'designation_level',
            DB::raw('count(*) as total')
        )
            ->groupBy('designation', 'organization', 'designation_level')
            ->orderBy('designation_level', 'asc') // lowest number first
            ->get()
            ->groupBy('designation')
            ->map(function ($items) {
                return $items->keyBy('organization');
            });

        $counts = MasterEmployee::selectRaw("
                    COUNT(*) as total_employees,
                    SUM(CASE WHEN class = 'I' THEN 1 ELSE 0 END) as class_I_count,
                    SUM(CASE WHEN class = 'II' THEN 1 ELSE 0 END) as class_II_count,
                    SUM(CASE WHEN class = 'III' THEN 1 ELSE 0 END) as class_III_count,
                    SUM(CASE WHEN class = 'IV' THEN 1 ELSE 0 END) as class_IV_count,

                    SUM(CASE WHEN category = 'T' THEN 1 ELSE 0 END) as tech_count,
                    SUM(CASE WHEN category = 'NT' THEN 1 ELSE 0 END) as non_tech_count,

                    SUM(CASE WHEN gender = 'Male' THEN 1 ELSE 0 END) as male_count,
                    SUM(CASE WHEN gender = 'Female' THEN 1 ELSE 0 END) as female_count,

                    COUNT(DISTINCT designation) as designation_count,
                    COUNT(DISTINCT organization) as organization_count,
                    COUNT(DISTINCT department) as department_count,
                    COUNT(DISTINCT core_department) as core_department_count
                ")->first();

        $orgWiseCounts = MasterEmployee::select(
            'organization',
            DB::raw("COUNT(*) as total_employees"),
            DB::raw("SUM(CASE WHEN class = 'I' THEN 1 ELSE 0 END) as class_I_count"),
            DB::raw("SUM(CASE WHEN class = 'II' THEN 1 ELSE 0 END) as class_II_count"),
            DB::raw("SUM(CASE WHEN class = 'III' THEN 1 ELSE 0 END) as class_III_count"),
            DB::raw("SUM(CASE WHEN class = 'IV' THEN 1 ELSE 0 END) as class_IV_count"),
            DB::raw("SUM(CASE WHEN category = 'T' THEN 1 ELSE 0 END) as tech_count"),
            DB::raw("SUM(CASE WHEN category = 'NT' THEN 1 ELSE 0 END) as non_tech_count"),
            DB::raw("SUM(CASE WHEN gender = 'Male' THEN 1 ELSE 0 END) as male_count"),
            DB::raw("SUM(CASE WHEN gender = 'Female' THEN 1 ELSE 0 END) as female_count"),
            DB::raw("COUNT(DISTINCT designation) as designation_count"),
            DB::raw("COUNT(DISTINCT department) as department_count"),
            DB::raw("COUNT(DISTINCT core_department) as core_department_count")
        )
            ->groupBy('organization')
            ->orderBy('organization')
            ->get();

        $orgWiseCountsforCharts = MasterEmployee::select(
            'organization',
            DB::raw("SUM(CASE WHEN class = 'I' THEN 1 ELSE 0 END) as class_I_count"),
            DB::raw("SUM(CASE WHEN class = 'II' THEN 1 ELSE 0 END) as class_II_count"),
            DB::raw("SUM(CASE WHEN class = 'III' THEN 1 ELSE 0 END) as class_III_count"),
            DB::raw("SUM(CASE WHEN class = 'IV' THEN 1 ELSE 0 END) as class_IV_count")
        )
            ->groupBy('organization')
            ->orderBy('organization')
            ->get()
            ->map(function ($item) {
                $item->short_name = strtoupper(implode('', array_map(
                    fn($word) => $word[0],
                    preg_split('/\s+/', $item->organization)
                )));
                return $item;
            });

        $classWiseDesignationCounts = MasterEmployee::select(
            'class',
            DB::raw('COUNT(DISTINCT designation) as designation_count')
        )
            ->whereIn('class', ['I', 'II', 'III', 'IV']) // limit to the classes you care about
            ->groupBy('class')
            ->orderByRaw("FIELD(class, 'I', 'II', 'III', 'IV')") // to preserve logical order
            ->get();

        return view(
            "employee.master-md-employees.index",
            [
                'designations' => $designations,
                'organizations' => $organizations,
                'counts' => $counts,
                'orgWiseCounts' => $orgWiseCounts,
                'classWiseDesignationCounts' => $classWiseDesignationCounts,
                'orgShortName' => $orgShortName,
                'orgWiseCountsforCharts' => $orgWiseCountsforCharts,
                'coreDepartments' => $coreDepartments,
                'designationsList' => $designationsList
            ]
        );
    }

    public function search(Request $request)
    {
        // check for Gate Entry
        if (!Gate::allows('master_md_employee_read')) {
            abort(401, "You are not Authorized to Access this Page !");
        }

        // get all distinct designations from MasterEmployee
        $organizations = MasterEmployee::select('organization')
            ->distinct()
            ->orderBy('organization', 'asc')
            ->pluck('organization', 'organization');

        $coreDepartments = MasterEmployee::select('core_department')
            ->whereNotNull('core_department')
            ->where('core_department', '!=', '')
            ->distinct()
            ->orderBy('core_department', 'asc')
            ->pluck('core_department', 'core_department');

        $designationsList = MasterEmployee::select('designation')
            ->whereNotNull('designation')
            ->where('designation', '!=', '')
            ->distinct()
            // ->orderBy('designation_level', 'asc')
            ->pluck('designation', 'designation');

        $employeeTypes = MasterEmployee::select('employee_type')
            ->distinct()
            ->orderBy('employee_type', 'asc')
            ->pluck('employee_type', 'employee_type');

        $employeeClasses = MasterEmployee::select('class')
            ->distinct()
            ->orderBy('class', 'asc')
            ->pluck('class', 'class');

        $orgShortName = array_map(function ($name) {
            // Split into words, take first letter of each, uppercase, and join
            return strtoupper(implode('', array_map(fn($word) => $word[0], preg_split('/\s+/', $name))));
        }, $organizations->toArray());

        $designations = MasterEmployee::select(
            'designation',
            'organization',
            'designation_level',
            DB::raw('count(*) as total')
        )
            ->groupBy('designation', 'organization', 'designation_level')
            ->orderBy('designation_level', 'asc') // lowest number first
            ->get()
            ->groupBy('designation')
            ->map(function ($items) {
                return $items->keyBy('organization');
            });

        $counts = MasterEmployee::selectRaw("
                    COUNT(*) as total_employees,
                    SUM(CASE WHEN class = 'I' THEN 1 ELSE 0 END) as class_I_count,
                    SUM(CASE WHEN class = 'II' THEN 1 ELSE 0 END) as class_II_count,
                    SUM(CASE WHEN class = 'III' THEN 1 ELSE 0 END) as class_III_count,
                    SUM(CASE WHEN class = 'IV' THEN 1 ELSE 0 END) as class_IV_count,

                    SUM(CASE WHEN category = 'T' THEN 1 ELSE 0 END) as tech_count,
                    SUM(CASE WHEN category = 'NT' THEN 1 ELSE 0 END) as non_tech_count,

                    SUM(CASE WHEN gender = 'Male' THEN 1 ELSE 0 END) as male_count,
                    SUM(CASE WHEN gender = 'Female' THEN 1 ELSE 0 END) as female_count,

                    COUNT(DISTINCT designation) as designation_count,
                    COUNT(DISTINCT organization) as organization_count,
                    COUNT(DISTINCT department) as department_count,
                    COUNT(DISTINCT core_department) as core_department_count
                ")->first();

        $orgWiseCounts = MasterEmployee::select(
            'organization',
            DB::raw("COUNT(*) as total_employees"),
            DB::raw("SUM(CASE WHEN class = 'I' THEN 1 ELSE 0 END) as class_I_count"),
            DB::raw("SUM(CASE WHEN class = 'II' THEN 1 ELSE 0 END) as class_II_count"),
            DB::raw("SUM(CASE WHEN class = 'III' THEN 1 ELSE 0 END) as class_III_count"),
            DB::raw("SUM(CASE WHEN class = 'IV' THEN 1 ELSE 0 END) as class_IV_count"),
            DB::raw("SUM(CASE WHEN category = 'T' THEN 1 ELSE 0 END) as tech_count"),
            DB::raw("SUM(CASE WHEN category = 'NT' THEN 1 ELSE 0 END) as non_tech_count"),
            DB::raw("SUM(CASE WHEN gender = 'Male' THEN 1 ELSE 0 END) as male_count"),
            DB::raw("SUM(CASE WHEN gender = 'Female' THEN 1 ELSE 0 END) as female_count"),
            DB::raw("COUNT(DISTINCT designation) as designation_count"),
            DB::raw("COUNT(DISTINCT department) as department_count"),
            DB::raw("COUNT(DISTINCT core_department) as core_department_count")
        )
            ->groupBy('organization')
            ->orderBy('organization')
            ->get();

        $orgWiseCountsforCharts = MasterEmployee::select(
            'organization',
            DB::raw("SUM(CASE WHEN class = 'I' THEN 1 ELSE 0 END) as class_I_count"),
            DB::raw("SUM(CASE WHEN class = 'II' THEN 1 ELSE 0 END) as class_II_count"),
            DB::raw("SUM(CASE WHEN class = 'III' THEN 1 ELSE 0 END) as class_III_count"),
            DB::raw("SUM(CASE WHEN class = 'IV' THEN 1 ELSE 0 END) as class_IV_count")
        )
            ->groupBy('organization')
            ->orderBy('organization')
            ->get()
            ->map(function ($item) {
                $item->short_name = strtoupper(implode('', array_map(
                    fn($word) => $word[0],
                    preg_split('/\s+/', $item->organization)
                )));
                return $item;
            });

        $classWiseDesignationCounts = MasterEmployee::select(
            'class',
            DB::raw('COUNT(DISTINCT designation) as designation_count')
        )
            ->whereIn('class', ['I', 'II', 'III', 'IV']) // limit to the classes you care about
            ->groupBy('class')
            ->orderByRaw("FIELD(class, 'I', 'II', 'III', 'IV')") // to preserve logical order
            ->get();

        return view(
            "employee.master-md-employees.search",
            [
                'designations' => $designations,
                'organizations' => $organizations,
                'counts' => $counts,
                'orgWiseCounts' => $orgWiseCounts,
                'classWiseDesignationCounts' => $classWiseDesignationCounts,
                'orgShortName' => $orgShortName,
                'orgWiseCountsforCharts' => $orgWiseCountsforCharts,
                'coreDepartments' => $coreDepartments,
                'designationsList' => $designationsList,
                'employeeTypes' => $employeeTypes,
                'employeeClasses' => $employeeClasses
            ]
        );
    }

    /**
     * AJAX method for employee data
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function filter(Request $request)
    {
        $query = MasterEmployee::query();

        if ($request->filled('organization')) {
            $query->where('organization', $request->input('organization'));
        }
        if ($request->filled('core_department')) {
            $query->where('core_department', $request->input('core_department'));
        }
        if ($request->filled('designation')) {
            $query->where('designation', $request->input('designation'));
        }
        if ($request->filled('employee_type')) {
            $query->where('employee_type', $request->input('employee_type'));
        }
        if ($request->filled('class')) {
            $query->where('class', $request->input('class'));
        }

        $employees = $query->select('employee_number', 'new_emp_no', 'name', 'organization', 'core_department', 'designation', 'employee_type', 'class')
            ->get();

        return response()->json([
            'data' => $employees
        ]);
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
     * Display the specified resource.
     */
    public function details(String $employeeNumber)
    {
        //
        $employee = MasterEmployee::where('new_emp_no', '=', $employeeNumber)->firstOrFail();
        $subordinates = MasterEmployee::where('supervisor_emp_no', '=',$employeeNumber )->get();
        return view("employee.master-md-employees.details", compact('employee', 'subordinates'));
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
