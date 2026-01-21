<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use HasFactory;

    protected $fillable = [
        'designation_id',
        'category',
        'department_id',
    ];

    /**
     * Add new Position from eUrja Data
     * 
     * @param mixed $data
     * @return Position
     */
    public static function add($data)
    {
        // add new Position
        try {
            //code...
            $postition = Position::firstOrCreate($data);
        } catch (\Throwable $th) {
            throw $th;
        }

        return $postition;
    }
}
