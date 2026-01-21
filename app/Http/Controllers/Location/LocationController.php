<?php

namespace App\Http\Controllers\Location;

use App\Helpers\FilterHelper;
use App\Http\Controllers\Controller;
use App\Models\Location\Location;
use App\Http\Requests\Location\StoreLocationRequest;
use App\Http\Requests\Location\UpdateLocationRequest;
use App\Models\Master\CoreDepartment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class LocationController extends Controller
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
        Gate::authorize('app_location_locations_read');
        
        // prepare query
        $related = ['company', 'eurjaLocations', 'departments', 'subDepartments', 'coreDepartments']; 

        // base query
        $query = Location::query();

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
            "app.location.locations.index",
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
    public function show(Location $location)
    {
        //
        Gate::authorize('app_location_locations_read');

        $location->load('eurjaLocations', 'company', 'departments', 'subDepartments', 'coreDepartments');

        dd($location->locationDepartments);
        
        $subs  = $location->subDepartments()->get();
        $cores = $location->coreDepartments()->get();

        // dd(CoreDepartment::find(6)->subDepartments, $subs, $cores);

        return view('app.location.locations.show', compact('location'));
    }
}
