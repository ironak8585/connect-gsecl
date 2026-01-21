<?php

namespace App\Models\Admin;

use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mattiverse\Userstamps\Traits\Userstamps;
use Spatie\Permission\Models\Permission as SpatiePermission;

class MyPermission extends SpatiePermission
{
    use SoftDeletes, Userstamps, Timestamp;

    protected $fillable = [
        'name',
        'guard_name',
        'description',
        'created_by',
        'updated_by',
        'deleted_by',
    ];



    // Mutators
    // set snack case
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = strtolower(str_replace(' ', '_', $value));
    }

    // set description title case
    public function setDescriptionAttribute($value)
    {
        $this->attributes['description'] = ucwords(strtolower(str_replace('_', ' ', $value)));
    }

    /**
     * List of all available Permissions within guard default web
     */
    public static function myPermissions($guardName = 'web')
    {
        return self::where('guard_name', $guardName)->pluck('description', 'id');
    }
}
