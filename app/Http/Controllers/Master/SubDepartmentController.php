<?php

namespace App\Http\Controllers\Master;

use App\Helpers\FilterHelper;
use App\Http\Controllers\Controller;
use App\Models\Master\CoreDepartment;
use App\Models\Master\SubDepartment;
use App\Http\Requests\Master\StoreSubDepartmentRequest;
use App\Http\Requests\Master\UpdateSubDepartmentRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class SubDepartmentController extends Controller
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
        Gate::authorize('master_core_departments_read');

        // prepare query
        $related = [];

        // base query
        $query = SubDepartment::query();

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
            "master.sub_departments.index",
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
        // Authorize the user
        Gate::authorize('master_sub_departments_manage');

        // Get core departments
        $coreDepartments = CoreDepartment::getList();

        return view('master.sub_departments.create', compact('coreDepartments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSubDepartmentRequest $request)
    {
        // Authorize the user
        Gate::authorize('master_sub_departments_manage');

        $validated = $request->validated();

        try {
            $subDepartment = SubDepartment::add($validated);
        } catch (\Throwable $th) {
            // throw $th;
            report($th);
            return redirect()->route('master.sub_departments.index')
                ->withErrors(['Failed to create sub department | ' . $th->getMessage()]);
        }

        return redirect()
            ->route('master.sub_departments.index')
            ->with('success', 'Sub department created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(SubDepartment $subDepartment)
    {
        // Authorize the user
        Gate::authorize('master_sub_departments_read');

        return view('master.sub_departments.show', compact('subDepartment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SubDepartment $subDepartment)
    {
        // Authorize the user
        Gate::authorize('master_sub_departments_manage');

        // Get core departments
        $coreDepartments = CoreDepartment::getList();

        // Types
        $types = config('constants.master.DEPARTMENT.TYPE');

        return view('master.sub_departments.edit', compact('subDepartment', 'coreDepartments', 'types'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSubDepartmentRequest $request, SubDepartment $subDepartment)
    {
        // Authorize the user
        Gate::authorize('master_sub_departments_manage');

        $validated = $request->validated();

        try {
            //code...
            $subDepartment->edit($validated);
        } catch (\Throwable $th) {
            report($th);
            return redirect()->route('master.sub_departments.index')
                ->withErrors(['Failed to edit sub department | ' . $th->getMessage()]);
        }

        return redirect()
            ->route('master.sub_departments.index')
            ->with('success', 'Sub department updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SubDepartment $subDepartment)
    {
        // Authorize the user
        Gate::authorize('master_sub_departments_manage');

        if ($subDepartment->remove()) {
            return redirect()->route('master.sub_departments.index')
                ->with('success', 'Sub department deleted successfully.');
        }

        return back()->withErrors(['Error occurred while deleting the sub department.']);
    }

    /**
     * To Restore the Trashed Record
     * @param mixed $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore($id)
    {
        // Authorize the user
        Gate::authorize('master_sub_departments_manage');

        $subDepartment = subDepartment::withTrashed()->findOrFail($id);

        if ($subDepartment->recover()) {
            return redirect()->route('master.sub_departments.index')
                ->with('success', 'Sub department restored successfully.');
        }

        return back()->withErrors(['Error occurred while restoring the sub department.']);
    }

    /**
     * forceDelete
     * 
     * @param mixed $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function forceDelete($id)
    {
        // Authorize the user
        Gate::authorize('master_sub_departments_manage');

        $subDepartment = SubDepartment::withTrashed()->findOrFail($id);

        if ($subDepartment->forceRemove()) {
            return redirect()->route('master.sub_departments.index')
                ->with('success', 'Sub department permanently deleted successfully.');
        }

        return back()->withErrors(['Error occurred while permanently deleting the sub department.']);
    }
}
