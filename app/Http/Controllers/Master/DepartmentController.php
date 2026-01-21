<?php

namespace App\Http\Controllers\Master;

use App\Helpers\FilterHelper;
use App\Http\Controllers\Controller;
use App\Models\Master\CoreDepartment;
use App\Models\Master\Department;
use App\Http\Requests\Master\UpdateDepartmentRequest;
use App\Models\Master\SubDepartment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        // Authorize the user
        Gate::authorize('master_departments_read');

        // prepare query
        $related = ['eurjaDepartment', 'subDepartment.coreDepartment'];

        // base query
        $query = Department::query();

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
            "master.departments.index",
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
    public function show(Department $department)
    {
        // Authorize the user
        Gate::authorize('master_departments_read');

        // dd($department->locationDepartments);

        return view('master.departments.show', compact('department'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Department $department)
    {
        // Authorize the user
        Gate::authorize('master_departments_manage');

        // Core departments
        $coreDepartments = CoreDepartment::pluck('name', 'id');

        // Sub Departments
        $subDepartments = SubDepartment::getSubDepartmentList();

        return view('master.departments.edit', compact('department',  'coreDepartments', 'subDepartments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDepartmentRequest $request, Department $department)
    {
        // Authorize the user
        Gate::authorize('master_departments_manage');

        try {
            //code...
            $department->edit($request->validated());
        } catch (\Throwable $th) {
            // throw $th;
            return redirect()->back()->with('error', 'Department updated successfully.');
        }

        return redirect()
            ->route('master.departments.index')
            ->with('success', 'Department updated successfully.');
    }
}
