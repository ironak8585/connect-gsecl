<?php

namespace App\Models\App\Request;

use App\Models\Employee\Employee;
use App\Models\Location\Department;
use App\Models\Location\Location;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TransferOperation extends Model
{
    protected $fillable = [
        'transfer_id',
        'employee_number',
        'from_location_id',
        'to_location_id',
        'from_department_id',
        'to_department_id',
        'effective_date',
        'relieving_date',
        'joining_date',
        'remarks',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'effective_date' => 'date',
        'relieving_date' => 'date',
        'joining_date' => 'date',
    ];

    // Relationships
    public function transfer(): BelongsTo
    {
        return $this->belongsTo(Transfer::class);
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'employee_number', 'employee_number');
    }

    public function fromLocation(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'from_location_id');
    }

    public function toLocation(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'to_location_id');
    }

    public function fromDepartment(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'from_department_id');
    }

    public function toDepartment(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'to_department_id');
    }
}
