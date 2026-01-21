<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('master_employees', function (Blueprint $table) {
            // $table->id();
            $table->unsignedBigInteger('employee_number')->primary();
            $table->index('employee_number');
            $table->foreignId('user_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('restrict');
            // $table->foreignId('eurja_employee_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('restrict');

            $table->string('old_emp_no')->nullable();
            $table->string('new_emp_no')->unique();
            $table->string('name');
            $table->string('designation')->nullable();
            $table->tinyInteger('designation_level')->nullable();
            $table->string('position')->nullable();
            $table->string('core_department')->nullable();
            $table->tinyInteger('core_department_level')->nullable();
            $table->string('department')->nullable();
            $table->string('organization')->nullable();
            $table->string('assignment_type')->nullable();
            $table->string('employee_type')->nullable();
            $table->string('supervisor_emp_no')->nullable();
            $table->string('supervisor_name')->nullable();
            $table->string('class')->nullable();
            $table->string('category')->nullable();
            $table->string('sh_nsh')->nullable();
            $table->string('union')->nullable();
            $table->date('dob')->nullable();
            $table->enum('gender', ['Male', 'Female', 'Other'])->nullable();
            $table->string('blood_group')->nullable();
            $table->string('disabled')->nullable();
            $table->string('pan_number')->nullable();
            $table->string('cpf_number')->nullable();
            $table->date('cpf_joining_date')->nullable();
            $table->string('eps_number')->nullable();
            $table->date('eps_joining_date')->nullable();
            $table->date('date_of_joining')->nullable();
            $table->string('bank')->nullable();
            $table->string('branch')->nullable();
            $table->string('bank_account_no')->nullable();
            $table->string('grade')->nullable();
            $table->string('grade_step')->nullable();
            $table->date('grade_start_date')->nullable();
            $table->decimal('basic', 10, 2)->nullable();
            $table->string('ot_code')->nullable();
            $table->boolean('svrcdbs_flag')->nullable();
            $table->date('next_increment')->nullable();
            $table->string('username')->nullable();
            $table->date('doj_current_cadre')->nullable();
            $table->date('last_higher_grade')->nullable();
            $table->date('doj_current_place')->nullable();
            $table->string('caste')->nullable();
            $table->string('qualification')->nullable();
            $table->boolean('restricted_ph')->nullable();
            $table->boolean('second_fourth_sat_not_app')->nullable();
            $table->integer('age')->nullable();
            $table->boolean('image_present')->nullable();
            $table->string('ifsc_code')->nullable();
            $table->string('aadhaar_number')->nullable();
            $table->string('pf_member_id')->nullable();
            $table->string('lic_id')->nullable();
            $table->string('pran')->nullable();
            $table->boolean('antecedent_verified')->nullable();
            $table->text('antecedent_remark')->nullable();
            $table->string('medical_exam')->nullable();
            $table->text('medical_remark')->nullable();
            $table->string('parent_company')->nullable();
            $table->string('deputed_from')->nullable();
            $table->string('last_location')->nullable();
            $table->text('deputation_remark')->nullable();
            $table->string('old_basic_grade')->nullable();
            $table->decimal('old_basic', 10, 2)->nullable();
            $table->date('old_basic_from')->nullable();
            $table->date('old_basic_to')->nullable();
            $table->boolean('pay_revision_flag')->nullable();
            $table->date('class3_doj_ho_cir')->nullable();
            $table->date('class4_doj_ho_cir_div')->nullable();
            $table->integer('years_on_current_cadre')->nullable();
            $table->integer('years_on_current_place')->nullable();
            $table->string('cleared_regional_lang')->nullable();
            $table->string('cleared_hindi_exam')->nullable();
            $table->string('cleared_departmental_exam')->nullable();
            $table->string('email')->nullable();
            $table->string('phone_no')->nullable();

            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();

            $table->timestamps();
            $table->softDeletes('deleted_at', precision: 0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_employees');
    }
};
