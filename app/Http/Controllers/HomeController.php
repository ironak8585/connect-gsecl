<?php

namespace App\Http\Controllers;

use App\Models\App\Content\Circular;
use App\Models\Employee\Employee;
use App\Models\Location\Location;
use App\Models\Master\CircularCategory;
use App\Models\Master\Department as MasterDepartment;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Home page for Guest View
     * 
     * @param Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $locations = Location::all();
        $departments = MasterDepartment::all();
        $employees = Employee::all();

        // Get last 10 circulars from circular model
        $circulars = Circular::latest()->take(10)->get();
        $circularCategories = CircularCategory::getCategories();

        // dd($circularCategories);

        return view("home", compact('locations', 'departments', 'employees', 'circulars', 'circularCategories'));
    }
}
