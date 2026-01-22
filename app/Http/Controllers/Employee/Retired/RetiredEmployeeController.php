<?php

namespace App\Http\Controllers\Employee\Retired;

use App\Http\Controllers\Controller;
use App\Models\Company\Company;
use App\Models\Location\Dispensary;
use App\Models\Location\Location;
use App\Models\Employee\RetiredEmployee;
use App\Http\Requests\Employee\StoreRetiredEmployeeRequest;
use App\Http\Requests\Employee\UpdateRetiredEmployeeRequest;
use Illuminate\Http\Request;

class RetiredEmployeeController extends Controller
{
    /**
     * Register page for the retired employees
     */
    public function register(Request $request)
    {
        if ($request->method() == 'GET') {
            //
            $companies = Company::pluck('name', 'id');
            $locations = Location::pluck('name', 'id');
            $dispensaries = Dispensary::pluck('name', 'id');

            return view('employee.retired-employees.register', compact(['companies', 'locations', 'dispensaries']));
        }
        elseif ($request->method() == 'POST') {
            # code...
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRetiredEmployeeRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(RetiredEmployee $retiredEmployee)
    {
        //
    }
}
