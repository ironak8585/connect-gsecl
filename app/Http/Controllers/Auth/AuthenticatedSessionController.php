<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Company\Company;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        // get companies
        $companies = Company::all()->pluck('name', 'id');

        return view('auth.login', compact('companies'));
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // setting up default company
        $request['company'] = 'gsecl';

        try {
            $request->authenticate();
            $request->session()->regenerate();

            return redirect()->intended(route('dashboard', absolute: false))
                ->with('success', 'Login successful!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()
                ->withInput($request->only('employee_number'))
                ->with('error', $e->getMessage());
        } catch (\Throwable $th) {
            return back()
                ->withInput($request->only('employee_number'))
                ->with('error', 'An unexpected error occurred. Please try again.' . $th->getMessage());
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
