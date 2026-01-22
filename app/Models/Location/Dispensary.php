<?php

namespace App\Models\Location;

use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mattiverse\Userstamps\Traits\Userstamps;

class Dispensary extends Model
{
    use Timestamp, Userstamps, SoftDeletes;
    
    protected $fillable = [
        'name',
        'company_id',
        'location_id',
        'address'
    ];


}
