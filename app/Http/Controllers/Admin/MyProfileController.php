<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\MyProfile;
use App\Http\Requests\Admin\StoreMyProfileRequest;
use App\Http\Requests\Admin\UpdateMyProfileRequest;
use Auth;

class MyProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return "Test";
    }

    /**
     * Sync with eUrja System
     */
    public function sync()
    {
        // sync with eUrja
        try {
            $user = MyProfile::syncEUrja(Auth::user());
        } catch (\Throwable $th) {
            throw $th;
        }

        return "Test";
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
    public function store(StoreMyProfileRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(MyProfile $myProfile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MyProfile $myProfile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMyProfileRequest $request, MyProfile $myProfile)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MyProfile $myProfile)
    {
        //
    }
}
