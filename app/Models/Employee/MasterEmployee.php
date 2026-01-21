<?php

namespace App\Models\Employee;

use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mattiverse\Userstamps\Traits\Userstamps;

class MasterEmployee extends Model
{
    use Userstamps, Timestamp, SoftDeletes;

    protected $primaryKey = 'employee_number';
    public $incrementing = false;
    protected $keyType = 'int';

    protected $fillable = [
        'employee_number',
        'old_emp_no',
        'new_emp_no',
        'name',
        'designation',
        'designation_level',
        'position',
        'core_department',
        'core_department_level',
        'department',
        'organization',
        'assignment_type',
        'employee_type',
        'supervisor_emp_no',
        'supervisor_name',
        'class',
        'category',
        'sh_nsh',
        'union',
        'dob',
        'gender',
        'blood_group',
        'disabled',
        'pan_number',
        'cpf_number',
        'cpf_joining_date',
        'eps_number',
        'eps_joining_date',
        'date_of_joining',
        'bank',
        'branch',
        'bank_account_no',
        'grade',
        'grade_step',
        'grade_start_date',
        'basic',
        'ot_code',
        'svrcdbs_flag',
        'next_increment',
        'username',
        'doj_current_cadre',
        'last_higher_grade',
        'doj_current_place',
        'caste',
        'qualification',
        'restricted_ph',
        'second_fourth_sat_not_app',
        'age',
        'image_present',
        'ifsc_code',
        'aadhaar_number',
        'pf_member_id',
        'lic_id',
        'pran',
        'antecedent_verified',
        'antecedent_remark',
        'medical_exam',
        'medical_remark',
        'parent_company',
        'deputed_from',
        'last_location',
        'deputation_remark',
        'old_basic_grade',
        'old_basic',
        'old_basic_from',
        'old_basic_to',
        'pay_revision_flag',
        'class3_doj_ho_cir',
        'class4_doj_ho_cir_div',
        'years_on_current_cadre',
        'years_on_current_place',
        'cleared_regional_lang',
        'cleared_hindi_exam',
        'cleared_departmental_exam',
        'email',
        'phone_no'
    ];

    // app/Models/MasterEmployee.php

    /**
     * Get the main curated employee record.
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'employee_number', 'employee_number');
    }

    public static function parseBool($value): ?bool
    {
        if (is_null($value))
            return null;

        $value = strtolower(trim((string) $value));
        return in_array($value, ['yes', 'y', 'true', '1']) ? true :
            (in_array($value, ['no', 'n', 'false', '0']) ? false : null);
    }

    public static function parseDate($value): ?string
    {
        try {
            return $value ? \Carbon\Carbon::parse($value)->format('Y-m-d') : null;
        } catch (\Exception $e) {
            return null;
        }
    }

    public static function parseFloat($value): ?float
    {
        return is_numeric($value) ? (float) $value : null;
    }

    public static function parseInt($value): ?int
    {
        return is_numeric($value) ? (int) $value : null;
    }

}
