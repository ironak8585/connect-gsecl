<?php

namespace App\Models\Location;

use App\Models\Master\Department;
use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mattiverse\Userstamps\Traits\Userstamps;

class LocationDepartment extends Model
{
    use Timestamp, Userstamps, SoftDeletes;

    protected $fillable = [
        'location_id',
        'department_id'
    ];

    /**
     * Relationships
     */
    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }


    /**
     * Add new department from eUrja Data
     * 
     * @param mixed $data
     * @return LocationDepartment
     */
    public static function add($data)
    {
        // add new department
        try {
            //code...
            $department = LocationDepartment::firstOrCreate($data);
        } catch (\Throwable $th) {
            throw $th;
        }

        return $department;
    }
}
