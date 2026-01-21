<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\MyPermission;
use App\Models\Admin\MyRole;
use DB;
use Illuminate\Http\Request;
use Str;

class RoleController extends Controller
{
    //

    public function __construct()
    {
        //
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Authorize the User
        if (!auth()->user()->can('admin_roles_read')) {
            return redirect()->route('dashboard')
                ->withErrors(['You do not have right permission to access this page.']);
        }

        $records = MyRole::withTrashed()->get();
        return view("admin.roles.index", compact("records"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Authorize the User
        if (!auth()->user()->can('admin_roles_manage')) {
            return redirect()->route('dashboard')
                ->withErrors(['You do not have right permission to access this page.']);
        }

        $permissions = MyPermission::where('guard_name', '=', 'web')->get()->pluck('description', 'id');

        return view('admin.roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Authorize the User
        if (!auth()->user()->can('admin_roles_manage')) {
            return redirect()->route('dashboard')
                ->withErrors(['You do not have right permission to access this page.']);
        }

        $data = $request->validate([
            "name" => "required",
            'description' => 'nullable|string|max:255',
            "permissions" => "required|array|min:1",
        ]);

        // get permissions
        $permissions = $request->input("permissions") ? $request->input("permissions") : [];
        $data = $request->except("permissions");
        $data['name'] = Str::upper(Str::snake(Str::lower($data['name'])));

        try {
            DB::transaction(function () use ($data, $permissions) {
                $role = MyRole::create($data);
                $role->permissions()->sync($permissions);
            });

            return redirect()->route('admin.roles.index')->with('success', 'Role created successfully');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->withErrors(['Error in Role Creation', $th->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(MyRole $role)
    {
        // Authorize the User
        if (!auth()->user()->can('admin_roles_read')) {
            return redirect()->route('dashboard')
                ->withErrors(['You do not have right permission to access this page.']);
        }

        return view('admin.roles.show', compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MyRole $role)
    {
        // Authorize the User
        if (!auth()->user()->can('admin_roles_manage')) {
            return redirect()->route('dashboard')
                ->withErrors(['You do not have right permission to access this page.']);
        }

        $permissions = MyPermission::myPermissions();
        return view('admin.roles.edit', compact('role', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Authorize the User
        if (!auth()->user()->can('admin_roles_manage')) {
            return redirect()->route('dashboard')
                ->withErrors(['You do not have right permission to access this page.']);
        }

        $role = MyRole::findOrFail($id);
        // Validate the request data
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
            'description' => 'nullable|string|max:255',
            'permissions' => 'array|min:1', // Ensure at least one permission is selected
        ]);
        $data['guard_name'] = 'web'; // Set the guard name to 'web' for the role

        // get permissions
        $permissions = $request->input("permissions") ? $request->input("permissions") : [];
        $data = $request->except("permissions");
        try {
            DB::transaction(function () use ($role, $data, $permissions) {
                $role->update($data);
                $role->permissions()->sync($permissions);
            });

            return redirect()->route('admin.roles.index')->with('success', 'Role updated successfully');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->withErrors(['Error in Role Update', $th->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Gate to check if user has permission to delete role
        if (!auth()->user()->can('admin_roles_manage')) {
            return redirect()->route('admin.roles.index')
                ->withErrors(['You do not have permission to delete roles.']);
        }

        $role = MyRole::findOrFail($id);
        if ($role->name == 'SUPER_ADMIN') {
            return redirect()->route('admin.roles.index')
                ->withErrors(['You cannot delete the SUPER_ADMIN role.']);
        }
        if ($role->name == 'ADMIN') {
            return redirect()->route('admin.roles.index')
                ->withErrors(['You cannot delete the ADMIN role.']);
        }
        try {
            DB::transaction(function () use ($role) {
                $role->delete();
            });

            return redirect()->route('admin.roles.index')->with('success', 'Role deleted successfully');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->withErrors(['Error in Role Deletion', $th->getMessage()]);
        }
    }

    /**
     * To Restore the Trashed Record
     * @param mixed $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore($id)
    {
        // Authorize the User
        if (!auth()->user()->can('admin_roles_manage')) {
            return redirect()->route('dashboard')
                ->withErrors(['You do not have right permission to access this page.']);
        }

        $role = MyRole::withTrashed()->findOrFail($id);
        $role->restore();
        $role->save();

        return redirect()->route('admin.roles.index')
            ->with('success', 'Role restored successfully.');
    }
}
