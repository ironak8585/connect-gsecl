<?php

namespace App\Models\Master;

use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mattiverse\Userstamps\Traits\Userstamps;

class SubDepartment extends Model
{
    use Userstamps, Timestamp, SoftDeletes;

    // define fillable attributes
    protected $fillable = [
        'core_department_id',
        'name',
        'slug',
    ];

    /** Relationship */
    // public function coreDepartment()
    // {
    //     return $this->belongsTo(CoreDepartment::class);
    // }

    public function coreDepartment()
    {
        return $this->belongsTo(CoreDepartment::class, 'core_department_id');
    }

    public function departments()
    {
        return $this->hasMany(Department::class, 'sub_department_id');
    }

    // public function departments()
    // {
    //     return $this->hasMany(Department::class);
    // }

    /**
     * Get Id of department
     * 
     * @param mixed $name
     * @param mixed $type
     * @return int
     */
    public static function getSubDepartmentId($name, $type)
    {
        return self::where('name', $name)
            ->where('type', $type)
            ->first()
            ->id;
    }

    public static function getSubDepartmentList()
    {
        return SubDepartment::pluck('name', 'id');
        // return self::select('id', 'name', 'type')
        //     ->get()
        //     ->pluck('sub_department_with_type', 'id');
    }

    /**
     * Add Sub Department
     * @param mixed $data
     * @return SubDepartment
     */
    public static function add($data)
    {
        try {
            //code...
            $subDepartment = SubDepartment::firstOrCreate($data);
        } catch (\Throwable $th) {
            throw $th;
        }

        return $subDepartment;
    }

    /**
     * Edit the Sub Department
     * @param mixed $data
     * @return static
     */
    public function edit($data)
    {
        try {
            //code...
            $this->update($data);
        } catch (\Throwable $th) {
            throw $th;
        }

        return $this;
    }


    /**
     * Soft delete the record
     *
     * @return bool
     */
    public function remove(): bool
    {
        try {
            return $this->delete();
        } catch (\Throwable $th) {
            report($th);
            return false;
        }
    }

    /**
     * Restore a soft-deleted record
     *
     * @return bool
     */
    public function recover(): bool
    {
        try {
            return $this->restore();
        } catch (\Throwable $th) {
            report($th);
            return false;
        }
    }

    /**
     * Permanently delete a record.
     *
     * @return bool
     */
    public function forceRemove(): bool
    {
        try {
            return $this->forceDelete();
        } catch (\Throwable $th) {
            report($th);
            return false;
        }
    }
}
