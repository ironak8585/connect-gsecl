<?php

namespace App\Models\Location;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EurjaLocation extends Model
{
    protected $fillable = [
        'location_id',
        'code',
        'name',
        'master'
    ];

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

    /**
     * Relationships
     */
    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class); 
    }

    /**
     * Add new location from eUrja Data
     * 
     * @param mixed $data
     * @return \App\Models\Location\EurjaLocation
     */
    public static function add($data)
    {
        // add new location
        try {
            //code...
            $eurjaLocation = EurjaLocation::firstOrCreate($data);
        } catch (\Throwable $th) {
            throw $th;
        }

        return $eurjaLocation;
    }

}
