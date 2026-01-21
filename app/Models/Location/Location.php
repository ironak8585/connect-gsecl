<?php

namespace App\Models\Location;

use App\Models\Company\Company;
use App\Models\Master\CoreDepartment;
use App\Models\Master\Department;
use App\Models\Master\SubDepartment;
use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mattiverse\Userstamps\Traits\Userstamps;

class Location extends Model
{
    use SoftDeletes, Userstamps, Timestamp;

    protected $fillable = [
        'company_id',
        'name',
        'slug',
    ];

    /**
     * Relationships
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function eurjaLocations()
    {
        return $this->hasMany(EurjaLocation::class);
    }

    public function locationDepartments(){
        return $this->hasManyThrough(LocationDepartment::class, Location::class);
    }
    // public function locationDepartments(){
    //     return $this->hasMany(LocationDepartment::class);
    // }

    //  public function departments()
    // {
    //     return $this->belongsToMany(
    //         Department::class,
    //         'location_departments',
    //         'location_id',
    //         'department_id'
    //     );
    // }


    // Many-to-many: Locations ↔ Departments through location_departments
    public function departments()
    {
        return $this->belongsToMany(
            Department::class,
            'location_departments',
            'location_id',
            'department_id'
        )->withTimestamps(); // if your pivot tracks timestamps
    }


    // Has Many Through SubDepartments (via departments)
    public function subDepartments()
    {
        return $this->hasManyThrough(
            SubDepartment::class,
            Department::class,
            'id',               // FK on Department (local key of departments)
            'id',               // FK on SubDepartment (local key)
            'id',               // local key on Location
            'sub_department_id' // foreign key on Department pointing to SubDepartment
        );
    }

    // Has Many Through CoreDepartments (from SubDepartments)
    public function coreDepartments()
    {
        return $this->hasManyThrough(
            CoreDepartment::class,
            SubDepartment::class,
            'core_department_id',  // SubDepartment → CoreDepartment
            'id',                  // CoreDepartment primary key
            'id',                  // Location primary key
            'id'                   // SubDepartment primary key
        );
    }

    /**
     * Get Helper Methods
     */
    public static function getLocations($purpose = null)
    {
        switch ($purpose) {
            case 'eUrjaFilter':
                $locations = self::all()->pluck('name', 'master');
                break;

            default:
                $locations = self::all()->pluck('name', 'id');
                break;
        }
        return $locations;
    }


    public function subDepartmentsList()
    {
        return SubDepartment::query()
            ->select('sub_departments.*')
            ->join('departments', 'departments.sub_department_id', '=', 'sub_departments.id')
            ->join('location_departments', 'location_departments.department_id', '=', 'departments.id')
            ->where('location_departments.location_id', $this->id)
            ->distinct();
    }

    public function coreDepartmentsList()
    {
        return CoreDepartment::query()
            ->select('core_departments.*')
            ->join('sub_departments', 'sub_departments.core_department_id', '=', 'core_departments.id')
            ->join('departments', 'departments.sub_department_id', '=', 'sub_departments.id')
            ->join('location_departments', 'location_departments.department_id', '=', 'departments.id')
            ->where('location_departments.location_id', $this->id)
            ->distinct();
    }



    /**
     * Add new location from eUrja Data
     * 
     * @param mixed $data
     * @return \App\Models\Location\location
     */
    public static function add($data)
    {
        // add new location
        try {
            //code...
            $location = Location::firstOrCreate($data);
        } catch (\Throwable $th) {
            throw $th;
        }

        return $location;
    }

}
