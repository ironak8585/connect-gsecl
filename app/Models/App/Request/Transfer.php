<?php

namespace App\Models\App\Request;

use App\Models\Employee\Employee;
use App\Models\Location\Department;
use App\Models\Location\Location;
use App\Models\Master\Designation;
use App\Models\User;
use Carbon\Traits\Timestamp;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mattiverse\Userstamps\Traits\Userstamps;

class Transfer extends Model
{
    use SoftDeletes, Timestamp, Userstamps;

    protected $fillable = [
        'employee_number',
        'current_location_id',
        'current_department_id',
        'current_designation_id',
        'native_place',
        'current_place',
        'is_spouse_case',
        'spouse_employee_number',
        'spouse_employee_location_id',
        'reason',
        'remarks',
        'is_renewed',
        'last_renewed_at',
        'hod_approver_employee_number',
        'hod_approved_at',
        'hod_remarks',
        'psc_approver_employee_number',
        'psc_approved_at',
        'psc_remarks',
        'status',
        'type',
        'cancelled_at',
        'cancellation_reason',
    ];

    protected $casts = [
        'hod_approved_at' => 'datetime',
        'psc_approved_at' => 'datetime',
        'last_renewed_at' => 'datetime',
        'cancelled_at' => 'datetime',
        'is_renewed' => 'boolean',
        'is_spouse_case' => 'boolean',
    ];

    // Relationships
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'employee_number', 'employee_number');
    }

    public function currentLocation(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'current_location_id');
    }

    public function currentDepartment(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'current_department_id');
    }

    public function currentDesignation(): BelongsTo
    {
        return $this->belongsTo(Designation::class, 'current_designation_id');
    }

    public function spouseEmployee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'spouse_employee_number');
    }

    public function spouseEmployeeLocation(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'spouse_employee_location_id');
    }

    public function hodApproverEmployee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'hod_approver_employee_number');
    }

    public function pscApproverEmployee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'psc_approver_employee_number');
    }

    public function preferences(): HasMany
    {
        return $this->hasMany(TransferPreference::class);
    }

    // public function preferencesHistory(): HasMany
    // {
    //     return $this->hasMany(TransferPreferencesHistory::class);
    // }

    // public function operations(): HasMany
    // {
    //     return $this->hasMany(TransferOperation::class);
    // }

    // Getters method
// FIRST preference location
    public function getFirstLocationAttribute()
    {
        return $this->preferences
            ->where('preference', config('constants.app.request.transfer.PREFERENCES.FIRST'))
            ->first();
    }

    // SECOND preference location
    public function getSecondLocationAttribute()
    {
        return $this->preferences
            ->where('preference', config('constants.app.request.transfer.PREFERENCES.SECOND'))
            ->first();
    }

    // THIRD preference location
    public function getThirdLocationAttribute()
    {
        return $this->preferences
            ->where('preference', config('constants.app.request.transfer.PREFERENCES.THIRD'))
            ->first();
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', config('constants.app.request.transfer.STATUS.REQUESTED'));
    }

    // public function scopeExpired($query)
    // {
    //     return $query->where('status', config('constants.app.request.transfer.STATUS.EXPIRED'))
    //         ->orWhere(function ($q) {
    //             $q->where('is_renewed', false);
    //         });
    // }

    // Helper methods
    public function isExpired(): bool
    {
        return $this['status'] === config('constants.app.request.transfer.STATUS.EXPIRED');
    }

    // public function needsRenewal(): bool
    // {
    //     return now()->month == 12 && !$this->is_renewed;
    // }

    // CRUD Methods
    /**
     * Create New Transfer 
     * 
     * @param mixed $data
     * @return Transfer
     */
    public static function add($data)
    {
        DB::beginTransaction();

        // create transfer request
        try {
            $transfer = Transfer::create($data);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }

        // prepare preferences
        $preferences = [];

        foreach ([
            'location_1' => config('constants.app.request.transfer.PREFERENCES.FIRST'),
            'location_2' => config('constants.app.request.transfer.PREFERENCES.SECOND'),
            'location_3' => config('constants.app.request.transfer.PREFERENCES.THIRD'),
        ] as $field => $prefTag) {

            if (!empty($data[$field])) {
                $preferences[] = [
                    'location_id' => $data[$field],
                    'preference' => $prefTag,
                    'request_date' => now(),
                ];
            }
        }

        // create preferences of transfers
        try {
            $transferPreferences = $transfer->preferences()->createMany($preferences);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }

        // create preference history
        try {
            //code...
        } catch (\Throwable $th) {
            // DB::rollBack();
            //throw $th;
        }

        DB::commit();

        return $transfer;
    }

    /**
     * Update the transfer
     * 
     * @param mixed $data
     * @return static
     */
    public function edit($data)
    {
        // update record
        try {
            $this->update($data);
        } catch (\Throwable $th) {
            throw $th;
        }

        return $this;
    }
}
