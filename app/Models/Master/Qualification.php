<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Qualification extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
    ];

    /**
     * Add new Qualification from eUrja Data
     * 
     * @param mixed $data
     * @return array
     */
    public static function bulkAdd($data)
    {
        // 
        $qualifications = [];

        // Add new qualification
        foreach ($data as $row) {
            try {
                //code...
                $qualification = Qualification::firstOrCreate(['name' => $row]);
            } catch (\Throwable $th) {
                throw $th;
            }

            array_push($qualifications, $qualification->id);
        }

        return $qualifications;
    }
}
