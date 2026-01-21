<?php

namespace App\Services;

use Illuminate\Support\Env;

class ApiClientService
{
    /**
     * To check if the API is reachable using cURL
     * @return bool
     */
    function isApiReachable(): bool
    {
        // Allow local authentication if accessing the site from outside
        if(Env('APP_ACCESS') == 'OUTSIDE_GSECL'){
            return true;
        }
        // internally call the callAuthApi
        // $response = $this->callAuthApi('gsecl', '26431', 'Dhriyan@123');
        // return $response['status'] == 'N' || $response['status'] == 'Y';

        $url = 'https://tpms.guvnl.com/API/hr_api/ValidateLogin.php';

        // STEP 1: Check URL reachability first
        $check = curl_init($url);
        curl_setopt($check, CURLOPT_NOBODY, true); // only check connection, no body
        curl_setopt($check, CURLOPT_TIMEOUT, 5);   // short timeout
        curl_setopt($check, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($check, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($check);

        if (curl_errno($check)) {
            curl_close($check);
            return false; // URL not reachable
        }

        $httpCode = curl_getinfo($check, CURLINFO_HTTP_CODE);
        curl_close($check);

        if ($httpCode < 200 || $httpCode >= 400) {
            return false; // Not reachable (like 404, 500, etc.)
        }

        return true;
    }

    /**
     * Summary of callAuthApi
     * 
     * @param mixed $company
     * @param mixed $employeeNumber
     * @param mixed $password
     * @throws \Exception
     */
    public function callAuthApi($company = 'gsecl', $employeeNumber, $password)
    {
        // dd($company, $employeeNumber, $password);

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://tpms.guvnl.com/API/hr_api/ValidateLogin.php');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_ENCODING, '');
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 0);
        curl_setopt($ch, CURLOPT_PROXY, '');
        // curl_setopt($ch, CURLOPT_PROXY, '172.16.15.20');
        // curl_setopt($ch, CURLOPT_PROXYPORT, '8080');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');

        // curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
            'company' => $company,
            'username' => $employeeNumber,
            'password' => $password,
        ]));

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            throw new \Exception(curl_error($ch));
        }

        curl_close($ch);

        return json_decode($response, true);
    }

    /**
     * Summary of callGetEmployeeDetailsApi
     * 
     * @param mixed $company
     * @param mixed $employeeNumber
     * @throws \Exception
     */
    public function callGetEmployeeDetailsApi($company = 'gsecl', $employeeNumber)
    {
        $url = 'https://tpms.guvnl.com/API/hr_api/GetEmployeeDetails.php?' . http_build_query([
            'company' => $company,
            'empno' => $employeeNumber,
        ]);

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_ENCODING, '');
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 0);
        curl_setopt($ch, CURLOPT_PROXY, ''); // disables proxy
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

        // Optional: Set User-Agent to mimic browser
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0');

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            throw new \Exception(curl_error($ch) . " API Error!");
        }

        curl_close($ch);

        return json_decode($response, true);
    }


    /**
     * Summary of callGetEmployeeDetailsApi
     * 
     * @param mixed $company
     * @throws \Exception
     */
    public function callGetAllEmployeeDetailsApi($company = 'gsecl')
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://tpms.guvnl.com/API/hr_api/GetAllEmployeeDetails.php');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_ENCODING, '');
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 0);
        curl_setopt($ch, CURLOPT_PROXY, '');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');

        // curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
            'company' => $company
        ]));

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            throw new \Exception(curl_error($ch) . "API Error !");
        }

        curl_close($ch);

        return json_decode($response, true);
    }
}