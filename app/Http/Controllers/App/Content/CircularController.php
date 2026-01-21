<?php

namespace App\Http\Controllers\App\Content;

use App\Helpers\FilterHelper;
use App\Http\Controllers\Controller;
use App\Models\App\Content\Circular;
use App\Http\Requests\Content\Circular\StoreCircularRequest;
use App\Http\Requests\Content\Circular\UpdateCircularRequest;
use App\Models\Master\CircularCategory;
use App\Services\FileUploadService;
use Auth;
use Gate;
use Illuminate\Http\Request;

class CircularController extends Controller
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
        Gate::authorize('app_content_circular_read');

        // prepare query
        $related = []; 

        // base query
        $query = Circular::query();

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
            "app.content.circulars.index",
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
        // Gate::authorize('app_content_circular_manage');

        if (!auth()->user()->can('app_content_circular_manage')) {
            return redirect()->route('app.content.circulars.index')
                ->withErrors(['You do not have permission to delete circular.']);
        }

        
        // get the circular categories
        $categories = CircularCategory::getCategories();

        return view("app.content.circulars.create", compact("categories"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCircularRequest $request)
    {
        // Authorize the user
        Gate::authorize('app_content_circular_manage');
        
        // get validated data
        $data = $request->validated();

        if ($request->hasFile('attachment')) {

            try {
                $fileName = FileUploadService::upload(
                    $request->file('attachment'),
                    config('constants.system.PATH.PREFIX.CIRCULAR')
                );

                if (!$fileName) {
                    return back()->withErrors(['attachment' => 'File upload failed. Please try again.']);
                }

                $data['attachment'] = $fileName;

            } catch (\Throwable $th) {
                // throw $th;
                report($th);
                return back()->withErrors(['attachment' => 'File upload failed. Please try again.']);
            }
        }

        try {
            //code...
            $circular = Circular::add($data);
        } catch (\Throwable $th) {
            throw $th;
        }

        return redirect()
            ->route('app.content.circulars.index')
            ->with('success', 'Circular created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Circular $circular)
    {
        // Authorize the user
        Gate::authorize('app_content_circular_read');
        
        //
        return view('app.content.circulars.show', compact('circular'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Circular $circular)
    {
        // Authorize the user
        Gate::authorize('app_content_circular_manage');
        
        // get the circular categories
        $categories = CircularCategory::getCategories();

        return view("app.content.circulars.edit", compact("circular", "categories"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCircularRequest $request, Circular $circular)
    {
        // Authorize the user
        Gate::authorize('app_content_circular_manage');
        
        //
        $data = $request->validated();

        // If change in the file
        if ($request->hasFile('attachment')) {

            $existingFile = config('constants.system.PATH.PREFIX.CIRCULAR') . "/" . $circular['attachment'];

            try {
                $fileName = FileUploadService::upload(
                    $request->file('attachment'),
                    config('constants.system.PATH.PREFIX.CIRCULAR'),
                    true,
                    $existingFile
                );

                if (!$fileName) {
                    return back()->withErrors(['attachment' => 'File upload failed. Please try again.']);
                }

                $data['attachment'] = $fileName;

            } catch (\Throwable $th) {
                // throw $th;
                report($th);
                return back()->withErrors(['attachment' => 'File upload failed. Please try again.']);
            }
        }

        try {
            $circular->edit($data);
        } catch (\Throwable $th) {
            throw $th;
        }

        return redirect()
            ->route('app.content.circulars.index')
            ->with('success', 'Circular updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     * Softdelte
     */
    public function destroy(Circular $circular)
    {
        // Authorize the user
        Gate::authorize('app_content_circular_manage');
        
        // Gate to check if user has permission to delete role
        // if (!auth()->user()->can('app_content_circular_manage')) {
        //     return redirect()->route('app.content.circulars.index')
        //         ->withErrors(['You do not have permission to delete circular.']);
        // }

        if ($circular->softRemove()) {
            return redirect()->route('app.content.circulars.index')
                ->with('success', 'Circular deleted successfully.');
        }

        return back()->withErrors(['Error occurred while deleting the circular.']);
    }

    /**
     * To Restore the Trashed Record
     * @param mixed $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore($id)
    {
        // Gate to check if user has permission to delete role
        if (!auth()->user()->can('app_content_circular_manage')) {
            return redirect()->route('app.content.circulars.index')
                ->withErrors(['You do not have permission to restore circular.']);
        }

        $circular = Circular::withTrashed()->findOrFail($id);

        if ($circular->restoreCircular()) {
            return redirect()->route('app.content.circulars.index')
                ->with('success', 'Circular restored successfully.');
        }

        return back()->withErrors(['Error occurred while restoring the circular.']);
    }


    public function forceDelete($id)
    {
        // Authorize the user
        Gate::authorize('app_content_circular_manage');

        $circular = Circular::withTrashed()->findOrFail($id);

        if ($circular->forceRemove()) {
            return redirect()->route('app.content.circulars.index')
                ->with('success', 'Circular permanently deleted successfully.');
        }

        return back()->withErrors(['Error occurred while permanently deleting the circular.']);
    }
}
