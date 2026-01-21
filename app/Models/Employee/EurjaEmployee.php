<?php

namespace App\Models\Employee;

use App\Models\User;
use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mattiverse\Userstamps\Traits\Userstamps;

class EurjaEmployee extends Model
{
    protected $table = 'eurja_employees';

    protected $primaryKey = 'employee_number';

    public $incrementing = false;

    protected $keyType = 'int';

    protected $fillable = [
        'user_id',
        'employee_number',
        // 'empno',
        'empname',
        'empdesig',
        'empposition',
        'empdepartment',
        'emplocation',
        'empclass',
        'empgender',
        'empcaste',
        'dtjoin',
        'dtjoincurrentplace',
        'dtlasthighergrade',
        'dtjoincurrentcadre',
        'dtofbirth',
        'empdisabled',
        'empcategory',
        'email',
        'phone',
        'bloodgroup',
        'qualification',
        'age',
        'yearscurrentcadre',
        'yearscurrentplace',
        'dtnextincrement',
        'basic',
        'personID',
        'imageData',
        'inchargeDesignation',
        'inchargeLocation',
        'p_status',
        'p_errmsg',
        'created_from',
    ];

    /**
     * Get the main curated employee record.
     */
    public function employee(): BelongsTo
    {
        // belongsTo(RelatedModel, foreignKeyOnThisModel, ownerKeyOnRelatedModel)
        return $this->belongsTo(Employee::class, 'employee_number', 'employee_number');
    }
    protected $casts = [
        'dtjoin' => 'date',
        'dtjoincurrentplace' => 'date',
        'dtlasthighergrade' => 'date',
        'dtjoincurrentcadre' => 'date',
        'dtofbirth' => 'date',
        'dtnextincrement' => 'date',
        'basic' => 'decimal:2',
        'age' => 'integer',
        'yearscurrentcadre' => 'integer',
        'yearscurrentplace' => 'integer',
    ];

    // add relationship with user
    public function user()
    {
        return $this->hasOne(User::class, 'employee_number', 'employee_number');
    }

    /**
     * Store an employee record using validated input data.
     *
     * @param  array  $data
     * @return self
     * @throws \Throwable
     */
    public static function storeEurjaEmployee(array $data): self
    {
        try {
            $eurjaEmployee = self::firstOrCreate($data);
        } catch (\Throwable $th) {
            // Optional: Log the error
            \Log::error('Failed to store EurjaEmployee: ' . $th->getMessage());
            throw $th;
        }

        return $eurjaEmployee;
    }
}
