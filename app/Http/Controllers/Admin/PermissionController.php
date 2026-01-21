<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\FilterHelper;
use App\Http\Controllers\Controller;
use App\Models\Admin\MyPermission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    /**
     * Creates new controller instance.
     * 
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Display the listing of resources
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // prepare query
        $related = [];
        $query = empty($related) ? MyPermission::query() : MyPermission::with($related);
        $query = FilterHelper::apply($request, $query, $equals = [], $skips = []);

        // get records
        $records = $query->withTrashed();
        $records = $query->paginate(FilterHelper::rpp($request));
        // $records = $query->paginate();

        // $records = $records->get();
        // dd($records);

        return view(
            "admin.permissions.index",
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
        return view('admin.permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name',
            'description' => 'nullable|string|max:255',
            'guard_name' => 'required|string|in:web,api', // Ensure guard_name is either 'web' or 'api'
        ]);

        $data['guard_name'] = 'web'; // Set the guard name to 'web' for the permissions

        // save the permission
        try {
            //code...
            MyPermission::create($data);
            return redirect()->route('admin.permissions.index')->with('success', 'Permission created successfully');
        } catch (\Throwable $th) {
            // throw $th;
            return back()->withErrors(['Error in Permission Creation', $th->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(MyPermission $permission)
    {
        // Render show page
        return view('admin.permissions.show', compact('permission'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MyPermission $permission)
    {
        //
        return view('admin.permissions.edit', compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MyPermission $permission)
    {
        // Validate the request data
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name,' . $permission->id,
            'description' => 'nullable|string|max:255',
            'guard_name' => 'required|string|in:web,api', // Ensure guard_name is either 'web' or 'api'
        ]);
        $data['guard_name'] = 'web'; // Set the guard name to 'web' for the role

        // get permissions
        try {
            $permission->update($data);
            return redirect()->route('admin.permissions.index')->with('success', 'Permission updated successfully');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->withErrors(['Error in Permission Update', $th->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Gate to check if user has permission to delete permission
        if (!auth()->user()->can('admin_permissions_manage')) {
            return redirect()->route('admin.permissions.index')
                ->withErrors(['You do not have permission to delete permissions.']);
        }

        $permission = MyPermission::findOrFail($id);

        try {
            $permission->delete();
            return redirect()->route('admin.permissions.index')->with('success', 'Permission deleted successfully');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->withErrors(['Error in Permission Deletion', $th->getMessage()]);
        }
    }

    /**
     * To Restore the Trashed Record
     * @param mixed $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore($id)
    {
        $permission = MyPermission::withTrashed()->findOrFail($id);
        $permission->restore();
        $permission->save();

        return redirect()->route('admin.permissions.index')
            ->with('success', 'Permission restored successfully.');
    }
}
