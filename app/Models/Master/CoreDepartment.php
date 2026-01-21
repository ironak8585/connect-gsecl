<?php

namespace App\Models\Master;

use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mattiverse\Userstamps\Traits\Userstamps;

class CoreDepartment extends Model
{
    use Timestamp, Userstamps, SoftDeletes;

    // define fillable attributes
    protected $fillable = [
        'name',
    ];

    /**
     * Relationships
     */
    // public function subDepartments()
    // {
    //     return $this->hasMany(SubDepartment::class);
    // }

    public function subDepartments()
    {
        return $this->hasMany(SubDepartment::class, 'core_department_id');
    }
    
    public function departments()
    {
        return $this->hasManyThrough(Department::class, SubDepartment::class);
    }

    /**
     * Get Id of department
     * 
     * @param mixed $name
     * @return int
     */
    public static function getCoreDepartmentId($name)
    {
        return self::where('name', $name)
            ->first()
            ->id;
    }

    /**
     * Get core department list
     * 
     * @return \Illuminate\Support\Collection<int|string, mixed>
     */
    public static function getList()
    {
        return self::all()->pluck('name', 'id');
    }

    /**
     * Add Core Department
     * @param mixed $data
     * @return CoreDepartment
     */
    public static function add($data)
    {
        try {
            //code...
            $coreDepartment = CoreDepartment::firstOrCreate($data);
        } catch (\Throwable $th) {
            throw $th;
        }

        return $coreDepartment;
    }

    /**
     * Edit the Core Department
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
     * Soft delete the core department
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
     * Restore a soft-deleted core department.
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
     * Permanently delete a circular and its file.
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
