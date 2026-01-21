<?php

namespace App\Models\Admin;

use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mattiverse\Userstamps\Traits\Userstamps;
use Spatie\Permission\Models\Role as SpatieRole;
use Str;

class MyRole extends SpatieRole
{
    use SoftDeletes, Timestamp, Userstamps;

    protected $fillable = [
        'name',
        'guard_name',
        'description',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    /**
     * Write Mutator for the Name attribute.
     * This mutator will automatically convert the name to uppercase and snake case.
     * for Example : "Admin Role" will be converted to "ADMIN_ROLE".
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = Str::upper(Str::snake(Str::lower($value)));
    }

    /**
     * Get Role Names function that returns an array of role names except SUPER_ADMIN
     * 
     * @param mixed $isAdmin
     * @return \Illuminate\Support\Collection<int|string, mixed>
     */
    public static function getRoleNames($isAdmin = false)
    {
        if ($isAdmin) {
            return self::pluck('name', 'id');
        }

        return self::where('name', '!=', 'SUPER_ADMIN')
            ->pluck('name', 'id');
    }

    /**
     * Get Role Name based on $id
     * 
     * @param mixed $id
     * @return \Illuminate\Support\Collection<int|string, mixed>
     */
    public static function getRoleName($id)
    {
        return self::find($id)->pluck('name', 'id');
    }

    /**
     * Get the role name based on the given ID.
     */
    public static function getRoleNameById($id)
    {
        return self::where('id', $id)
            ->value('name');
    }

}
