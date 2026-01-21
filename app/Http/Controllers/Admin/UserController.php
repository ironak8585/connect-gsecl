<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\FilterHelper;
use App\Http\Controllers\Controller;
use App\Models\Admin\MyRole;
use App\Models\Location\Location;
use App\Models\User;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Str;

class UserController extends Controller
{
    /**
     * Create new controller instance
     */
    public function __construct()
    {
    }

    /**
     * Get current logged user
     *
     * @return User
     */
    public function user(Request $request)
    {
        return $request->user();
    }


    /**
     * Display list of users
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        // check for Gate Entry
        if (!Gate::allows('admin_users_manage')) {
            abort(401, "You are not Authorized to Access this Page !");
        }

        // filter helpers
        $related = ['roles'];
        $query = empty($related) ? User::query() : User::with($related);
        // $query = $query->whereDoesntHave('roles', function ($query) {
        //     $query->where('name', 'SUPER_ADMIN');
        // });
        $query = FilterHelper::apply($request, $query, $equals = [], $skips = []);

        // get records
        if (auth()->user()->hasRole('SUPER_ADMIN')) {
            // If the user is a super admin, show all users including soft deleted ones
            $query = $query->withTrashed();
        } else {
            // If the user is not a super admin, show only active users
            $query = $query->whereNull('deleted_at');
        }
        $records = $query->paginate(FilterHelper::rpp($request));

        // Get locations
        $locations = Location::all()->pluck('name', 'id');

        // Get YES NO constant for filter
        $status = config('constants.master.YES_NO');

        return view(
            "admin.users.index",
            [
                'records' => $records,
                'filters' => FilterHelper::filters($request),
                'rpp' => FilterHelper::rpp($request),
                'roles' => MyRole::getRoleNames(),
                'locations' => $locations,
                'status' => $status
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Get roles
        $roles = MyRole::getRoleNames();

        // Get locations
        $locations = Location::all()->pluck('name', 'id');

        // dd($locations);

        return view('admin.users.create', compact('roles', 'locations'));
    }

    /**
     * Assign the Role to the User
     * 
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Contracts\View\View | \Illuminate\Http\RedirectResponse
     */
    public function assignRole(Request $request, User $user)
    {
        // check for Gate Entry
        if (!Gate::allows('admin_roles_manage')) {
            abort(401, "You are not Authorized to Access this Page !");
        }

        // Get roles
        $roles = MyRole::getRoleNames();

        // Render view
        if ($request->isMethod('GET')) {
            return view('admin.users.assign-role', compact('user', 'roles'));
        }

        if ($request->isMethod('POST')) {
            $request->validate([
                'role' => ['required', 'exists:roles,id'],
            ]);

            // Existing roles
            $existingRoles = $user->roles;

            // Add new role
            $newRoles = $existingRoles->push($roles[$request->input('role')]);

            // Assign role
            $user->syncRoles($newRoles);

            return redirect()->route('admin.users.index')->with('success', 'Role assigned successfully');
        }

        return redirect()->route('admin.users.index')->with('success', 'Role assigned successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validate fields
        $data = $request->validate([
            'employee_number' => ['required', 'numeric', 'min:1000', 'max:99999', 'unique:' . User::class],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'roles' => ['required', 'array', 'min:1'],
        ]);

        // reformat the name string
        $data['name'] = Str::title($data['name']);

        // separate the roles
        $roles = $request->input('roles') ? $request->input("roles") : [];

        DB::beginTransaction();

        try {
            // create user
            $user = User::create([
                'employee_number' => $data['employee_number'],
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($request->string('password')),
            ]);

        } catch (\Throwable $th) {
            DB::rollBack();
            // throw $th;
            return back()->withErrors(['Error in User Creation', $th->getMessage()]);
        }

        $user = User::with('roles')->where('employee_number', '=', $data['employee_number'])->first();

        // assign roles
        try {
            foreach ($roles as $roleId) {
                $user->assignRole(MyRole::getRoleName($roleId));
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
            // return back()->withErrors(['Error in Role Assignment', $th->getMessage()]);
        }

        DB::commit();
        return redirect()->route('admin.users.index')->with('success', 'User created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // get user
        $editUser = User::find($id);

        // TEMPORARY FIX [ TODO : Make it Proper ]
        // Get roles
        if ($editUser['employee_number'] == 26431)
            $roles = MyRole::getRoleNames(true);
        else
            $roles = MyRole::getRoleNames();

        // Get locations
        $locations = Location::pluck('name', 'id');

        // Assigned Roles
        $assignedRoles = $editUser->roles->pluck('id')->toArray();

        // Location Id
        $userLocation = $editUser->location_id;

        return view('admin.users.edit', compact('editUser', 'roles', 'locations', 'assignedRoles', 'userLocation'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::with('roles')->findOrFail($id);

        $data = $request->validate([
            'location_id' => ['required', 'exists:locations,id'],
            'roles' => ['required', 'array', 'min:1'],   // array of role IDs
        ]);

        DB::beginTransaction();

        try {
            // Sync roles using IDs directly
            $user->roles()->sync($request->roles);

            // Update the user
            $user->update($data);

            DB::commit();

        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->withErrors([
                'error' => 'Error while updating user: ' . $th->getMessage()
            ]);
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
