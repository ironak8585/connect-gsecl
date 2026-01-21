<?php

namespace App\Http\Requests\Auth;

use App\Models\Admin\EUrja;
use App\Models\Company\Company;
use App\Models\Employee\Employee;
use App\Models\Employee\EurjaEmployee;
use App\Models\User;
use Carbon\Carbon;
use DB;
use Exception;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // 'email' => ['required', 'string', 'email'],
            'employee_number' => ['required', 'numeric'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        // Validating from eUrja Credentials
        $company = $this->input('company');
        $employeeNumber = $this->input('employee_number');
        $password = $this->input('password');

        // Check if user exist in users table of the project
        try {
            //code...
            $user = User::where('employee_number', $employeeNumber)->first();
        } catch (\Throwable $th) {
            throw new Exception('Error fetching user details from Intranet Data');
        }

        // check if api is reachable
        // try {
        //     $isApiReachable = EUrja::isApiReachable();
        // } catch (\Throwable $th) {
        //     throw new Exception('Error Checking Connection with eUrja API');
        // }

        // if user already exist then check for login
        if ($user) {

            // check if user is active or not
            if ($user->is_active == 0) {
                RateLimiter::hit($this->throttleKey());

                throw ValidationException::withMessages([
                    'employee_number' => 'User is not active',
                ]);
            }

            // check if last eUrja synced at is null or more than 15 days or validate through eUrja is true
            if ($user->last_eUrja_synced_at === null || Carbon::parse($user->last_eUrja_synced_at)->diffInDays(now()) > 15 || $user->validate_through_eUrja == 1) {

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

                $isAuthenticated = EUrja::eUrjaAuthenticate($company, $employeeNumber, $password);

                // If user exist in eUrja then update the last eUrja synced at
                if ($isAuthenticated) {
                    $user->update([
                        'last_eUrja_synced_at' => now(),
                        'validate_through_eUrja' => false,
                    ]);

                    // check if user has changed the password of eUrja then change the password in local as well
                    $data = [
                        'employee_number' => $employeeNumber,
                        'password' => Hash::make($password),
                    ];

                    // update the password in local db
                    $user->updatePassword($data);

                } else {
                    // If user does not exist in eUrja then show error message
                    RateLimiter::hit($this->throttleKey());

                    // Check if the rate limit has been exceeded
                    if (RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
                        // Deactivate user if authenticated
                        $user->is_active = false;
                        $user->save();

                        // return response()->json(['message' => 'Too many attempts. User has been deactivated.'], 429);
                        throw ValidationException::withMessages([
                            'employee_number' => 'Too many attempts. User has been deactivated',
                        ]);
                    } else {
                        $user->update([
                            'last_eUrja_synced_at' => now(),
                            'validate_through_eUrja' => true,
                        ]);

                        throw ValidationException::withMessages([
                            'employee_number' => 'User does not exist in eUrja ! Rate Limiter Hits',
                        ]);
                    }
                }
            } else {
                // validate the user through local db
                if (!Auth::attempt($this->only('employee_number', 'password'), $this->boolean('remember'))) {

                    // check if api is reachable
                    try {
                        $isApiReachable = EUrja::isApiReachable();
                    } catch (\Throwable $th) {
                        // throw $th;
                        throw new Exception('Error Checking Connection with eUrja API');
                    }

                    // Return error if API is not reachable
                    if (!$isApiReachable) {
                        throw new Exception('Error Connecting to eUrja API ! Seems like you have changed the eUrja Credentials ! Check your internet connection, proxy settings or contact IT Team.');
                    }

                    // user has changed the password in eUrja then check the password in eUrja
                    try {
                        //code...
                        $isAuthenticated = EUrja::eUrjaAuthenticate($company, $employeeNumber, $password);
                    } catch (\Throwable $th) {
                        // throw $th;
                        throw new Exception('Error in Authenticating with eUrja API');
                    }

                    // If user exist in eUrja then update the last eUrja synced at
                    if ($isAuthenticated) {
                        $user->update([
                            'last_eUrja_synced_at' => now(),
                            'validate_through_eUrja' => false,
                        ]);

                        // check if user has changed the password of eUrja => then change the password in local as well
                        $data = [
                            'employee_number' => $employeeNumber,
                            'password' => Hash::make($password),
                        ];

                        // update the password in local db
                        try {
                            //code...
                            $user->updatePassword($data);
                        } catch (\Throwable $th) {
                            // throw $th;
                            throw new Exception('Error in Updating Password in Local DB');
                        }
                    } else {
                        // If user does not exist in eUrja then show error message
                        RateLimiter::hit($this->throttleKey());

                        // Check if the rate limit has been exceeded
                        if (RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
                            // Deactivate user if authenticated
                            $user->is_active = false;
                            $user->validate_through_eUrja = true;
                            $user->save();

                            // return response()->json(['message' => 'Too many attempts. User has been deactivated.'], 429);

                            throw ValidationException::withMessages([
                                'employee_number' => trans('auth.failed')
                            ]);
                        }
                    }
                }
            }
        } else {
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

            // check if user exist in eUrja
            try {
                $isAuthenticated = EUrja::eUrjaAuthenticate($company, $employeeNumber, $password);
            } catch (\Throwable $th) {
                // throw $th;
                throw new Exception('Error in Authenticating with eUrja API');
            }

            // if status is true : eUrja Authenticated then get the employees eUrja Details
            if ($isAuthenticated) {
                try {
                    //code...
                    $employeeEurjaData = EUrja::eUrjaGetEmployeeDetails($company, $employeeNumber);
                } catch (\Throwable $th) {
                    // throw $th;
                    throw new Exception('Error in Fetching Employee Details from eUrja API');
                }
            } else {
                RateLimiter::hit($this->throttleKey());

                // Check if the rate limit has been exceeded
                if (RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
                    // Deactivate user if authenticated
                    $user->is_active = false;
                    $user->save();

                    // return response()->json(['message' => 'Too many attempts. User has been deactivated.'], 429);
                    throw ValidationException::withMessages([
                        'employee_number' => 'Too many attempts. User has been deactivated',
                    ]);
                } else {
                    throw ValidationException::withMessages([
                        'employee_number' => 'User does not exist in eUrja',
                    ]);
                }
            }

            DB::beginTransaction();

            // If details with status success received then create eUrja Employee
            if ($employeeEurjaData['p_status'] == 'success') {

                // create the user

                // prepare basic data
                // if user does not exist then create a new user
                $userData = [
                    'name' => $employeeEurjaData['empname'],
                    'company_id' => Company::getCompanyByShortName($company)->id,
                    'email' => $employeeEurjaData['email'],
                    'employee_number' => $employeeNumber,
                    'password' => Hash::make($password),
                    'last_eUrja_synced_at' => now(),
                    'validate_through_eUrja' => false
                ];

                // if user does not exist then create a new user
                try {
                    //code...
                    $user = User::register($userData);
                } catch (\Throwable $th) {
                    DB::rollBack();
                    throw new Exception('Failed to register a new user');
                }

                // Add user_id to eUrja data
                $employeeEurjaData['user_id'] = $user->id;
                $employeeEurjaData['created_from'] = 'eUrjaApi';

                // create new eUrja Employee for the user
                // try {
                //     // call eUrja Employee Register Model
                //     $eurjaEmployee = EurjaEmployee::storeEurjaEmployee($employeeEurjaData);
                // } catch (\Throwable $th) {
                //     DB::rollBack();
                //     throw new Exception('Failed to register eUrja employee');
                // }

                // check if the employee is availbale on eurja data
                try {
                    $eurjaEmployee = EurjaEmployee::find((int)$user->employee_number);
                } catch (\Throwable $th) {
                    DB::rollBack();
                    throw new Exception('Failed to check employee in eurja data');
                }

                // Check if employee is available in eurja data (synced)
                if(!$eurjaEmployee) {
                    DB::rollBack();
                    throw new Exception('Employee not found in eUrja Synced Data');
                }

                // create new employee - model based
                try {
                    $employee = Employee::storeEmployeeOnIntranet($eurjaEmployee);
                } catch (\Throwable $th) {
                    DB::rollBack();
                    throw new Exception('Failed to register employee on Intranet');
                }

                // update the location related details of User model
                try {
                    $user->location_id = $employee->location_id;
                    $user->last_eUrja_synced_at = now();
                    // $user->is_active = true;
                    $user->save(); // Save changes to DB
                } catch (\Throwable $th) {
                    DB::rollBack();
                    \Log::error('ERROR: Failed to update user details: ' . $th->getMessage());
                    throw new Exception('Failed to update user details');
                }

                DB::commit();

            } else {
                throw new Exception('Failed to retrieve employee details from eUrja API');
            }

            DB::commit();
        }
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('email')) . '|' . $this->ip());
    }
}
