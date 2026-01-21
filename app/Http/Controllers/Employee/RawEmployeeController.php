<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Employee\RawEmployee;
use App\Http\Requests\Employee\StoreRawEmployeeRequest;
use App\Http\Requests\Employee\UpdateRawEmployeeRequest;

class RawEmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
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
    public function store(StoreRawEmployeeRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(RawEmployee $rawEmployee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RawEmployee $rawEmployee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRawEmployeeRequest $request, RawEmployee $rawEmployee)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RawEmployee $rawEmployee)
    {
        //
    }
}
