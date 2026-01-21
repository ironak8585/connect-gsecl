<?php

namespace App\Http\Controllers\Employee\Retired;

use App\Http\Controllers\Controller;
use App\Models\Company\Company;
use App\Models\RetiredEmployee;
use App\Http\Requests\StoreRetiredEmployeeRequest;
use App\Http\Requests\UpdateRetiredEmployeeRequest;
use Illuminate\Http\Request;

class RetiredEmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Register page for the retired employees
     */
    public function register(Request $request)
    {
        if ($request->method() == 'GET') {
            //
            $companies = Company::pluck('name', 'id');

            return view('employee.retired-employees.register', compact(['companies']));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RetiredEmployee $retiredEmployee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRetiredEmployeeRequest $request, RetiredEmployee $retiredEmployee)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RetiredEmployee $retiredEmployee)
    {
        //
    }
}
