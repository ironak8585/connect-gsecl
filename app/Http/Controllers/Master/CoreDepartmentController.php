<?php

namespace App\Http\Controllers\Master;

use App\Helpers\FilterHelper;
use App\Http\Controllers\Controller;
use App\Models\Master\CoreDepartment;
use App\Http\Requests\Master\StoreCoreDepartmentRequest;
use App\Http\Requests\Master\UpdateCoreDepartmentRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class CoreDepartmentController extends Controller
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
        $query = CoreDepartment::query();

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
            "master.core_departments.index",
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
        Gate::authorize('master_core_departments_manage');

        return view('master.core_departments.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCoreDepartmentRequest $request)
    {
        // Authorize the user
        Gate::authorize('master_core_departments_manage');

        $validated = $request->validated();

        try {
            $coreDepartment = CoreDepartment::add($validated);
        } catch (\Throwable $th) {
            // throw $th;
            report($th);
            return redirect()->route('master.core_departments.index')
                ->withErrors(['Failed to create core department | ' . $th->getMessage()]);
        }

        return redirect()
            ->route('master.core_departments.index')
            ->with('success', 'Core department created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(CoreDepartment $coreDepartment)
    {
        // Authorize the user
        Gate::authorize('master_core_departments_read');

        $coreDepartment->load('subDepartments', 'departments');

        return view('master.core_departments.show', compact('coreDepartment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CoreDepartment $coreDepartment)
    {
        // Authorize the user
        Gate::authorize('master_core_departments_manage');

        return view('master.core_departments.edit', compact('coreDepartment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCoreDepartmentRequest $request, CoreDepartment $coreDepartment)
    {
        // Authorize the user
        Gate::authorize('master_core_departments_manage');

        $validated = $request->validated();

        try {
            //code...
            $coreDepartment->edit($validated);
        } catch (\Throwable $th) {
            report($th);
            return redirect()->route('master.core_departments.index')
                ->withErrors(['Failed to edit core department | ' . $th->getMessage()]);
        }

        return redirect()
            ->route('master.core_departments.index')
            ->with('success', 'Core department updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CoreDepartment $coreDepartment)
    {
        // Authorize the user
        Gate::authorize('master_core_departments_manage');

        if ($coreDepartment->remove()) {
            return redirect()->route('master.core_departments.index')
                ->with('success', 'Core department deleted successfully.');
        }

        return back()->withErrors(['Error occurred while deleting the core department.']);
    }

    /**
     * To Restore the Trashed Record
     * @param mixed $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore($id)
    {
        // Authorize the user
        Gate::authorize('master_core_departments_manage');

        $coreDepartment = CoreDepartment::withTrashed()->findOrFail($id);

        if ($coreDepartment->recover()) {
            return redirect()->route('master.core_departments.index')
                ->with('success', 'Core department restored successfully.');
        }

        return back()->withErrors(['Error occurred while restoring the core department.']);
    }


    public function forceDelete($id)
    {
        // Authorize the user
        Gate::authorize('master_core_departments_manage');

        $coreDepartment = CoreDepartment::withTrashed()->findOrFail($id);

        if ($coreDepartment->forceRemove()) {
            return redirect()->route('master.core_departments.index')
                ->with('success', 'Core department permanently deleted successfully.');
        }

        return back()->withErrors(['Error occurred while permanently deleting the core department.']);
    }
}
