<?php

namespace App\Models\Employee;

use Illuminate\Database\Eloquent\Model;

class RawEmployee extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'emp_no',
        'old_emp_no',
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
        'caste',
        'blood_group',
        'disabled',
        'qualification',
        'restricted_ph',
        'second_fourth_sat_not_app',
        'age',
        'image_present',
        'image_data',
        'ifsc_code',
        'bank',
        'branch',
        'bank_account_no',
        'pan_number',
        'cpf_number',
        'cpf_joining_date',
        'eps_number',
        'eps_joining_date',
        'date_of_joining',
        'doj_current_cadre',
        'last_higher_grade',
        'doj_current_place',
        'next_increment',
        'years_on_current_cadre',
        'years_on_current_place',
        'basic',
        'grade',
        'grade_step',
        'grade_start_date',
        'ot_code',
        'svrcdbs_flag',
        'username',
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
        'cleared_regional_lang',
        'cleared_hindi_exam',
        'cleared_departmental_exam',
        'email',
        'phone',
        'incharge_designation',
        'incharge_location',
        'person_id',
        'is_eurja_api_synced',
        'is_eurja_api_synced_at',
        'is_eurja_master_synced',
        'is_eurja_master_synced_at',
        'p_status',
        'p_errmsg',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'dob' => 'date',
        'cpf_joining_date' => 'date',
        'eps_joining_date' => 'date',
        'date_of_joining' => 'date',
        'doj_current_cadre' => 'date',
        'last_higher_grade' => 'date',
        'doj_current_place' => 'date',
        'next_increment' => 'date',
        'grade_start_date' => 'date',
        'old_basic_from' => 'date',
        'old_basic_to' => 'date',
        'class3_doj_ho_cir' => 'date',
        'class4_doj_ho_cir_div' => 'date',

        'restricted_ph' => 'boolean',
        'second_fourth_sat_not_app' => 'boolean',
        'image_present' => 'boolean',
        'svrcdbs_flag' => 'boolean',
        'antecedent_verified' => 'boolean',
        'pay_revision_flag' => 'boolean',

        'is_eurja_api_synced' => 'boolean',
        'is_eurja_api_synced_at' => 'timestamp',
        'is_eurja_master_synced' => 'boolean',
        'is_eurja_master_synced_at' => 'timestamp',
    ];

    /**
     * Scope a query to order by core department.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOrderByCoreDepartment($query)
    {
        return $query->orderBy('core_department');
    }
}
