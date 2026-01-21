<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display the listing of resources
     */
    public function index(Request $request)
    {
        return view("dashboard");
    }
}
