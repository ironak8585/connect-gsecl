<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Designation extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'class',
    ];


    /**
     * Add new Designation from eUrja Data
     * 
     * @param mixed $data
     * @return Designation
     */
    public static function add($data)
    {
        // add new Designation
        try {
            //code...
            $designation = Designation::firstOrCreate($data);
        } catch (\Throwable $th) {
            throw $th;
        }

        return $designation;
    }
}
