<?php

namespace App\Models\Admin;

use App\Services\ApiClientService;

/**
 * For EUrja Related Calls and Transactions
 */
class EUrja
{
    /**
     * Check if the eUrja API is reachable
     *
     * @return bool
     */
    public static function isApiReachable(): bool
    {
        $apiClient = app(ApiClientService::class);
        return $apiClient->isApiReachable();
    }

    /**
     * Authenticate the user from eUrja API
     * 
     * @param mixed $company
     * @param mixed $employeeNumber
     * @param mixed $password
     * @return bool
     */
    public static function eUrjaAuthenticate($company = 'gsecl', $employeeNumber, $password)
    {
        $apiClient = app(ApiClientService::class);

        try {
            $response = $apiClient->callAuthApi($company, $employeeNumber, $password);

            // Ensure response is an array and has 'status'
            if (is_array($response) && isset($response['status'])) {
                return $response['status'] === 'Y';
            }

            // Unexpected response format
            \Log::warning("Unexpected API response", ['response' => $response]);
            return false;

        } catch (\Throwable $th) {
            // throw $th;
            \Log::error("eUrja authentication failed", [
                'employeeNumber' => $employeeNumber,
                'error' => $th->getMessage()
            ]);

            // Optional: notify via email or Sentry, etc.
            return false;
        }
    }

    /**
     * Get the user details from eUrja API
     * 
     * @param mixed $company
     * @param mixed $employeeNumber
     * @return array<string, mixed>|null
     */
    public static function eUrjaGetEmployeeDetails($company, $employeeNumber)
    {
        $apiClient = app(ApiClientService::class);

        try {
            $response = $apiClient->callGetEmployeeDetailsApi($company, $employeeNumber);

            // Check if response is valid (optional: add more specific checks)
            if (is_array($response) && !empty($response)) {
                return $response;
            }

            // Log unexpected response format
            \Log::warning("Unexpected API response from eUrjaGetEmployeeDetails", [
                'company' => $company,
                'employeeNumber' => $employeeNumber,
                'response' => $response,
            ]);

            return null;

        } catch (\Throwable $th) {
            \Log::error("Failed to fetch employee details from eUrja", [
                'company' => $company,
                'employeeNumber' => $employeeNumber,
                'error' => $th->getMessage(),
            ]);

            return null;
        }
    }


    /**
     * Get All eUrja Employees from eUrja API
     * 
     * @param mixed $company
     * @return array<string, mixed>|null
     */
    public static function eUrjaGetAllEmployeeDetails($company = 'gsecl')
    {
        $apiClient = app(ApiClientService::class);

        try {
            $response = $apiClient->callGetAllEmployeeDetailsApi($company);

            if (is_array($response) && !empty($response)) {
                return $response;
            }

            // Log unexpected or empty response
            \Log::warning("Unexpected or empty response from eUrjaGetAllEmployeeDetails", [
                'company' => $company,
                'response' => $response,
            ]);

            return null;

        } catch (\Throwable $th) {
            \Log::error("Failed to fetch all employee details from eUrja", [
                'company' => $company,
                'error' => $th->getMessage(),
            ]);

            return null;
        }
    }

}