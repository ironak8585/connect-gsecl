<?php

namespace App\Models\Admin;

use App\Services\EUrja;
use Illuminate\Database\Eloquent\Model;

class EurjaEmployee extends Model
{
    protected $table = 'eurja_employees';
    protected $primaryKey = 'employee_number';
    public $incrementing = false;
    protected $keyType = 'int';

    protected $fillable = [
        'employee_number',
        'empname',
        'empdesig',
        'empposition',
        'empdepartment',
        'emplocation',
        'empclass',
        'empgender',
        'empcaste',
        'dtjoin',
        'dtjoincurrentplace',
        'dtlasthighergrade',
        'dtjoincurrentcadre',
        'dtofbirth',
        'empdisabled',
        'empcategory',
        'email',
        'phone',
        'bloodgroup',
        'qualification',
        'age',
        'yearscurrentcadre',
        'yearscurrentplace',
        'dtnextincrement',
        'basic',
        'personID',
        'imageData',
        'inchargeDesignation',
        'inchargeLocation',
        'p_status',
        'p_errmsg',
    ];

    protected $casts = [
        'dtjoin' => 'date',
        'dtjoincurrentplace' => 'date',
        'dtlasthighergrade' => 'date',
        'dtjoincurrentcadre' => 'date',
        'dtofbirth' => 'date',
        'dtnextincrement' => 'date',
        'basic' => 'decimal:2',
        'age' => 'integer',
        'yearscurrentcadre' => 'integer',
        'yearscurrentplace' => 'integer',
    ];

    /**
     * Store an employee record using validated input data.
     *
     * @param  array  $data
     * @return self
     * @throws \Throwable
     */
    public static function storeEurjaEmployee(array $data): self
    {
        try {
            $eurjaEmployee = self::create($data);
        } catch (\Throwable $th) {
            // Optional: Log the error
            \Log::error('Failed to store EurjaEmployee: ' . $th->getMessage());
            throw $th;
        }

        return $eurjaEmployee;
    }

    /**
     * Sync eUrja Employees
     */
    public static function sync($company = 'gsecl')
    {
        // get eUrja employees
        try {
            $eurjaEmployees = EUrja::eUrjaGetAllEmployeeDetails();
        } catch (\Throwable $th) {
            throw new \Exception('Unable to Get the Employees Details from eUrja | ' . $th->getMessage());
        }

        // transform empno to employee_number
        $eurjaEmployees = array_map(function ($emp) {
            // copy value
            $emp['employee_number'] = (int) ($emp['empno'] ?? 0); // convert to integer

            // remove old key
            unset($emp['empno']);

            return $emp;
        }, $eurjaEmployees);

        // truncate the existing employees 
        if ($eurjaEmployees != null) {
            try {
                // EurjaEmployee::truncate();
                EurjaEmployee::query()->delete();
            } catch (\Throwable $th) {
                throw new \Exception('Unable to Truncate the eUrja Employee | ' . $th->getMessage());
            }
        }

        // create records
        try {
            foreach (array_chunk($eurjaEmployees, 1000) as $chunk) {
                EurjaEmployee::insert($chunk);
            }
        } catch (\Throwable $th) {
            throw new \Exception('Unable to Create the Records from eUrja Employees Data | ' . $th->getMessage());
        }

    }
}
