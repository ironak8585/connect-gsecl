<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Admin\EUrja;
use Exception;
use Illuminate\Http\Request;

class AuthProxyController extends Controller
{
    //
    public function login(Request $request)
    {
        // Validate input
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Access the data
        $username = $request->input('username');
        $password = $request->input('password');

        // login logic goes here
        $loginStatus = $this->attemptLogin($username, $password);

        return response()->json([
            'success' => $loginStatus
        ]);
    }

    // Just a placeholder for your logic
    private function attemptLogin($employeeNumber, $password)
    {
        // Place your curl/e-Urja API logic here and return true/false
        $company = "gsecl";

        // check if api is reachable
        try {
            $isApiReachable = EUrja::isApiReachable();
        } catch (\Throwable $th) {
            // throw $th;
            throw new Exception('Error Checking Connection with eUrja API');
        }

        // Return error if API is not reachable
        if (!$isApiReachable) {
            throw new Exception('Error Connecting to eUrja API ! Check your internet connection, proxy settings or contact IT Team.');
        }

        try {
            //code...
            $isAuthenticated = EUrja::eUrjaAuthenticate($company, $employeeNumber, $password);
        } catch (\Throwable $th) {
            throw $th;
        }

        return $isAuthenticated; // or false based on actual result
    }
}
