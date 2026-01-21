<?php

namespace App\Models\Admin;

use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mattiverse\Userstamps\Traits\Userstamps;

class EurjaDepartment extends Model
{
    use SoftDeletes, Timestamp, Userstamps;
}
