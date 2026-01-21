<?php

namespace App\Models\Employee;

use App\Models\Location\EurjaLocation;
use App\Models\Location\Location;
use App\Models\Master\Department;
use App\Models\Master\Designation;
use App\Models\User;
use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mattiverse\Userstamps\Traits\Userstamps;

class Employee extends Model
{
    use Userstamps, Timestamp, SoftDeletes;

    protected $primaryKey = 'employee_number';
    public $incrementing = false;
    protected $keyType = 'int';

    protected $fillable = [
        'employee_number',
        'user_id',
        'company_id',
        'location_id',
        'department_id',
        'designation_id',
        'incharge_location_id',
        'incharge_designation_id',
        'name',
        'email',
        'phone',
        'basic',
        'date_of_birth',
        'date_of_company_joining',
        'date_of_current_location_joining',
        'date_of_current_cadre_joining',
        'date_of_last_higher_grade',
        'date_of_next_increment',
        'disability',
        'category',
        'gender',
        'caste',
        'bloodgroup',
        'status',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'date_of_company_joining' => 'date',
        'date_of_current_location_joining' => 'date',
        'date_of_current_cadre_joining' => 'date',
        'date_of_last_higher_grade' => 'date',
        'date_of_next_increment' => 'date',
    ];

    // Relationships
    /**
     * Get the raw eUrja data associated with the employee.
     */
    public function eurjaEmployee(): HasOne
    {
        return $this->hasOne(EurjaEmployee::class, 'employee_number', 'employee_number');
    }

    /**
     * Get the raw Master data associated with the employee.
     */
    public function masterEmployee(): HasOne
    {
        return $this->hasOne(MasterEmployee::class, 'employee_number', 'employee_number');
    }

    /**
     * Get the location associated with the employee.
     */
    public function location(): BelongsTo
    {
        // This remains standard because 'location_id' uses Laravel's default 'id' PK
        return $this->belongsTo(Location::class); 
    }

    /**
     * Get the location associated with the employee.
     */
    public function department(): BelongsTo
    {
        // This remains standard because 'location_id' uses Laravel's default 'id' PK
        return $this->belongsTo(Department::class); 
    }

    /**
     * Get the location associated with the employee.
     */
    public function designation(): BelongsTo
    {
        // This remains standard because 'location_id' uses Laravel's default 'id' PK
        return $this->belongsTo(Designation::class); 
    }

    /**
     * Register the employee on Intranet based on eUrja Data
     * 
     * @param \App\Models\Employee\EurjaEmployee $eurjaEmployee
     * @return Employee
     */
    public static function storeEmployeeOnIntranet(EurjaEmployee $eurjaEmployee): Employee
    {
        // check if the employee already exists in the intranet
        try {
            $existingEmployee = self::where('employee_number', $eurjaEmployee['id'])->first();
        } catch (\Throwable $th) {
            \Log::error('ERROR in Checking Existing Employee on Intranet: ' . $th->getMessage());
            throw new \Exception('Error in Checking Existing Employee on Intranet');
        }

        // if employee already exists then update the employee details
        if ($existingEmployee) {
            return $existingEmployee; // return the existing employee
        }

        // prepare data for eUrja
        try {
            //code...
            $data = self::prepareEmployeeData($eurjaEmployee);
        } catch (\Throwable $th) {
            \Log::error('ERROR in Preparation of Data from EUrja Response: ' . $th->getMessage());
            throw $th;
        }

        // create Employee
        try {
            $employee = Employee::firstOrCreate($data);
        } catch (\Throwable $th) {
            \Log::error('ERROR in Creation of Employee on Intranet: ' . $th->getMessage());
            throw $th;
        }

        return $employee;
    }

    /**
     * Sync with eUrja System
     */
    public function syncEUrja(User $user)
    {
        dd($user);
    }

    /**
     * Prepare the data to be stored in Employee Model of the Application
     * 
     * @param \App\Models\Employee\EurjaEmployee $eurjaEmployee
     * @return array
     */
    private static function prepareEmployeeData(EurjaEmployee $eurjaEmployee)
    {
        // get company id based on user_id
        $companyId = $eurjaEmployee->user['company_id'];

        // get eUrja Location
        try {
            $eUrjaLocation = EurjaLocation::where('master', $eurjaEmployee['emplocation'])->first();
        } catch (\Throwable $th) {
            \Log::error('Employee Model> prepareEmployeeData()> Unable to Get the Location based on eUrja Data [code] : ' . $th->getMessage());
            throw $th;
        }

        // get the location id
        $locationId = $eUrjaLocation->location->id;

        // get department based on the department name $eurjaEmployee->empdepartment
        try {
            $parts = explode(':', $eurjaEmployee['empdepartment']);
            $department = end($parts);

            $departmentId = Department::where('name', $department)->first()['id'];
        } catch (\Throwable $th) {
            \Log::error('Employee Model> prepareEmployeeData()> Unable to Get the Department based on eUrja Data [name] : ' . $th->getMessage());
            throw $th;
        }

        // get designationId based on the designation name $eurjaEmployee->empdesig
        try {
            $designationId = Designation::where('name', $eurjaEmployee['empdesig'])->first()['id'];
        } catch (\Throwable $th) {
            \Log::error('Employee Model> prepareEmployeeData()> Unable to Get the Designation based on eUrja Data [name] : ' . $th->getMessage());
            throw $th;
        }

        $inchargeLocationId = null;

        // if inchargeLocation is not null then get the location id
        if ($eurjaEmployee['inchargeLocation']) {
            // get eUrja Location
            try {
                $eUrjaLocation = EurjaLocation::where('master', $eurjaEmployee['inchargeLocation'])->first();
            } catch (\Throwable $th) {
                \Log::error('Employee Model> prepareEmployeeData()> Unable to Get the inchargeLocation based on eUrja Data [name] : ' . $th->getMessage());
                throw $th;
            }

            // if eUrja Location found for inchargeLocation
            if($eUrjaLocation){
                $inchargeLocationId = $eUrjaLocation->location->id;
            }
        }

        // incharge locations department id
        $inchargeDesignationId = null;

        // if inchargeDesignation is not null then get the location id
        if ($eurjaEmployee['inchargeDesignation']) {
            try {
                //code...
                $inchargeDesignationId = Designation::where('name', explode(':', $eurjaEmployee['inchargeDesignation'])[0])->first()['id'];
            } catch (\Throwable $th) {
                \Log::error('Employee Model> prepareEmployeeData()> Unable to Get the inchargeDesignation based on eUrja Data [name] : ' . $th->getMessage());
                throw $th;
            }
        }

        return [
            'employee_number' => $eurjaEmployee['employee_number'],
            'user_id' => $eurjaEmployee->user['id'],
            'company_id' => $companyId,
            'location_id' => $locationId,
            'department_id' => $departmentId,
            'designation_id' => $designationId,
            'incharge_location_id' => $inchargeLocationId ?? null,
            'incharge_designation_id' => $inchargeDesignationId ?? null,
            'name' => $eurjaEmployee['empname'],
            'email' => $eurjaEmployee['email'],
            'phone' => $eurjaEmployee['phone'],
            'basic' => $eurjaEmployee->basic,
            'date_of_birth' => $eurjaEmployee->dtofbirth,
            'date_of_company_joining' => $eurjaEmployee->dtjoin,
            'date_of_current_location_joining' => $eurjaEmployee->dtjoincurrentplace,
            'date_of_current_cadre_joining' => $eurjaEmployee->dtjoincurrentcadre,
            'date_of_last_higher_grade' => $eurjaEmployee->dtlasthighergrade,
            'date_of_next_increment' => $eurjaEmployee->dtnextincrement,
            'disability' => ($eurjaEmployee['disability'] == 'Y') ? true : false,
            'category' => $eurjaEmployee['empcategory'],
            'gender' => array_search(strtoupper($eurjaEmployee['empgender']), config('constants.admin.EMPLOYEE.GENDER')),
            'caste' => array_search(strtoupper($eurjaEmployee['empcaste']), config('constants.admin.EMPLOYEE.CASTE')),
            'bloodgroup' => array_search(strtoupper($eurjaEmployee['bloodgroup']), config('constants.admin.EMPLOYEE.BLOODGROUP')),
            'status' => config('constants.admin.EMPLOYEE.STATUS.ACTIVE'),
        ];
    }
}
