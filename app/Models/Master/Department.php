<?php

namespace App\Models\Master;

use App\Models\Admin\EurjaDepartment;
use App\Models\Location\Location;
use App\Models\Location\LocationDepartment;
use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mattiverse\Userstamps\Traits\Userstamps;

class Department extends Model
{
    use Timestamp, SoftDeletes, Userstamps;

    protected $table = 'departments';

    // define fillable attributes
    protected $fillable = [
        'eurja_department_id',
        'sub_department_id',
        'name',
        'type',
    ];

    /**
     * Relationships
     */
    public function subDepartment()
    {
        return $this->belongsTo(SubDepartment::class, 'sub_department_id');
    }

    // Convenience: directly reach CoreDepartment through SubDepartment
    public function coreDepartment()
    {
        return $this->hasOneThrough(
            CoreDepartment::class,
            SubDepartment::class,
            'id',                 // SubDepartment's local key
            'id',                 // CoreDepartment's local key
            'sub_department_id',  // Department's foreign key to SubDepartment
            'core_department_id'  // SubDepartment's foreign key to CoreDepartment
        );
        // Note: hasOneThrough here returns one CoreDepartment per Department.
        // If you prefer belongsTo through, just use $this->subDepartment->coreDepartment in code.
    }

    public function locationDepartments(){
        return $this->hasMany(LocationDepartment::class);
    }
    
    // Reverse of Location->departments (optional)
    public function locations()
    {
        return $this->belongsToMany(
            Location::class,
            'location_departments',
            'department_id',
            'location_id'
        )->withTimestamps();
    }

    public function eurjaDepartment(): BelongsTo
    {
        return $this->belongsTo(EurjaDepartment::class, 'eurja_department_id');
    }

    // public function subDepartment(): BelongsTo
    // {
    //     return $this->belongsTo(SubDepartment::class, 'sub_department_id');
    // }

    // public function locations()
    // {
    //     return $this->belongsToMany(Location::class, 'location_departments');
    // }

    /**
     * Get Id of department
     * 
     * @param mixed $name
     * @param mixed $type
     * @return int
     */
    public static function getDepartmentId($name, $type)
    {
        return self::where('name', $name)
            ->where('type', $type)
            ->first()
            ->id;
    }

    public static function getDepartmentList()
    {
        // return SubDepartment::pluck('name', 'id');
        return self::select('id', 'name', 'type')
            ->get()
            ->pluck('department_with_type', 'id');
    }

    public function getDepartmentWithTypeAttribute()
    {
        return $this->name . ' [ ' . $this->type . ' ]';
    }

    public function edit($data)
    {
        try {
            //code...
            $this->update(['sub_department_id' => $data['sub_department_id']]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

}
