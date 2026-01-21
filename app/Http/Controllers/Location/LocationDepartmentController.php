<?php

namespace App\Http\Controllers\Location;

use App\Http\Controllers\Controller;
use App\Models\Location\LocationDepartment;
use App\Http\Requests\Location\StoreLocationDepartmentRequest;
use App\Http\Requests\Location\UpdateLocationDepartmentRequest;
use Illuminate\Http\Request;

class LocationDepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
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
    public function store(StoreLocationDepartmentRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(LocationDepartment $locationDepartment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LocationDepartment $locationDepartment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLocationDepartmentRequest $request, LocationDepartment $locationDepartment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LocationDepartment $locationDepartment)
    {
        //
    }
}
