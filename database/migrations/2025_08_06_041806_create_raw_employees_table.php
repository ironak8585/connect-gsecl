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
        Schema::create('raw_employees', function (Blueprint $table) {
            $table->id();

            // Links to the user who owns or created this record
            $table->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('restrict')
                ->comment('Linked user account (if any)');

            // Employee identifiers
            $table->string('emp_no')->unique()->comment('Unique employee number (current)');
            $table->string('old_emp_no')->nullable()->comment('Previous employee number, if any');

            // Basic details
            $table->string('name')->comment('Full name of employee');
            $table->string('designation')->nullable()->comment('Designation/title of the employee');
            $table->unsignedTinyInteger('designation_level')->nullable()->comment('level of designation of the employee for Ordering');
            $table->string('position')->nullable()->comment('Position/post of the employee');
            $table->string('core_department')->nullable()->comment('Core department');
            $table->string('core_department_level')->nullable()->comment('Core department level for Ordering');
            $table->string('department')->nullable()->comment('Functional department');
            $table->string('organization')->nullable()->comment('Organization or unit name');
            $table->string('assignment_type')->nullable()->comment('Type of assignment (e.g., permanent, deputation)');
            $table->string('employee_type')->nullable()->comment('Type of employee (e.g., Class I, II, III)');
            $table->string('supervisor_emp_no')->nullable()->comment('Employee number of supervisor');
            $table->string('supervisor_name')->nullable()->comment('Name of the supervisor');

            // Classification
            $table->string('class', 10)->nullable()->comment('Employee class/category');
            $table->string('category', 10)->nullable()->comment('Reservation category');
            $table->string('sh_nsh')->nullable()->comment('Shift type: SH/NSH');
            $table->string('union')->nullable()->comment('Union name (if any)');

            // Personal Info
            $table->date('dob')->nullable()->comment('Date of birth');
            $table->enum('gender', ['Male', 'Female', 'Other'])->nullable()->comment('Gender');
            $table->string('caste')->nullable()->comment('Caste/Community');
            $table->string('blood_group', 5)->nullable()->comment('Blood group');
            $table->string('disabled', 5)->nullable()->comment('Disability status (Y/N)');
            $table->string('qualification')->nullable()->comment('Educational qualification');
            $table->boolean('restricted_ph')->nullable()->comment('Restricted for PH duty');
            $table->boolean('second_fourth_sat_not_app')->nullable()->comment('Second/Fourth Saturday not applicable');

            // Age and image
            $table->integer('age')->nullable()->comment('Current age of employee');
            $table->boolean('image_present')->nullable()->comment('Whether image is present (Y/N)');
            $table->longText('image_data')->nullable()->comment('Raw image data (base64)');

            // Banking
            $table->string('ifsc_code')->nullable()->comment('Bank IFSC code');
            $table->string('bank')->nullable()->comment('Bank name');
            $table->string('branch')->nullable()->comment('Bank branch name');
            $table->string('bank_account_no')->nullable()->comment('Employee bank account number');

            // PF and PAN
            $table->string('pan_number')->nullable()->comment('PAN card number');
            $table->string('cpf_number')->nullable()->comment('CPF number');
            $table->date('cpf_joining_date')->nullable()->comment('CPF joining date');
            $table->string('eps_number')->nullable()->comment('EPS number');
            $table->date('eps_joining_date')->nullable()->comment('EPS joining date');

            // Joining and cadre details
            $table->date('date_of_joining')->nullable()->comment('Original date of joining');
            $table->date('doj_current_cadre')->nullable()->comment('Date of joining current cadre');
            $table->date('last_higher_grade')->nullable()->comment('Date of last higher grade');
            $table->date('doj_current_place')->nullable()->comment('Date of joining current place');
            $table->date('next_increment')->nullable()->comment('Next increment date');

            $table->integer('years_on_current_cadre')->nullable()->comment('Years on current cadre');
            $table->integer('years_on_current_place')->nullable()->comment('Years on current place');

            // Pay info
            $table->decimal('basic', 10, 2)->nullable()->comment('Current basic pay');
            $table->string('grade')->nullable()->comment('Grade of the employee');
            $table->string('grade_step')->nullable()->comment('Step within grade');
            $table->date('grade_start_date')->nullable()->comment('Start date of current grade');

            $table->string('ot_code')->nullable()->comment('OT Code (if any)');
            $table->boolean('svrcdbs_flag')->nullable()->comment('Flag for SVRC/DBS');

            // Credentials
            $table->string('username')->nullable()->comment('System username');

            // IDs
            $table->string('aadhaar_number')->nullable()->comment('Aadhaar number');
            $table->string('pf_member_id')->nullable()->comment('PF member ID');
            $table->string('lic_id')->nullable()->comment('LIC ID');
            $table->string('pran')->nullable()->comment('PRAN (Pension Account) number');

            // Background checks
            $table->boolean('antecedent_verified')->nullable()->comment('Whether antecedents are verified');
            $table->text('antecedent_remark')->nullable()->comment('Remarks on antecedents');
            $table->string('medical_exam')->nullable()->comment('Medical exam status');
            $table->text('medical_remark')->nullable()->comment('Medical remarks');

            // Transfer/deputation
            $table->string('parent_company')->nullable()->comment('Parent company in case of deputation');
            $table->string('deputed_from')->nullable()->comment('Transferred/deputed from');
            $table->string('last_location')->nullable()->comment('Previous location');
            $table->text('deputation_remark')->nullable()->comment('Remarks on deputation');

            // Past pay data
            $table->string('old_basic_grade')->nullable()->comment('Previous grade');
            $table->decimal('old_basic', 10, 2)->nullable()->comment('Previous basic pay');
            $table->date('old_basic_from')->nullable()->comment('Start date of old basic');
            $table->date('old_basic_to')->nullable()->comment('End date of old basic');
            $table->boolean('pay_revision_flag')->nullable()->comment('Pay revision applied or not');

            // Additional joining details
            $table->date('class3_doj_ho_cir')->nullable()->comment('Class 3 HO/CIR joining date');
            $table->date('class4_doj_ho_cir_div')->nullable()->comment('Class 4 HO/CIR/Division joining date');

            // Language/Exam clearances
            $table->string('cleared_regional_lang')->nullable()->comment('Cleared regional language');
            $table->string('cleared_hindi_exam')->nullable()->comment('Cleared Hindi exam');
            $table->string('cleared_departmental_exam')->nullable()->comment('Cleared departmental exam');

            // Contact
            $table->string('email')->nullable()->comment('Email address');
            $table->string('phone', 20)->nullable()->comment('Phone number');

            // Reporting/Control
            $table->string('incharge_designation')->nullable()->comment('In-charge designation');
            $table->string('incharge_location')->nullable()->comment('In-charge location');

            $table->string('person_id')->nullable()->comment('Person ID (unique mapping)');

            // sync related
            $table->boolean('is_eurja_api_synced')->default(false)->comment('Whether data is synced with eUrja API');
            $table->timestamp('is_eurja_api_synced_at')->nullable()->comment('Timestamp when data was synced with eUrja API');
            $table->boolean('is_eurja_master_synced')->default(false)->comment('Whether data is synced with eUrja Master');
            $table->timestamp('is_eurja_master_synced_at')->nullable()->comment('Timestamp when data was synced with eUrja Master');

            $table->string('p_status', 20)->default('success')->comment('Process status');
            $table->text('p_errmsg')->nullable()->comment('Process error message (if any)');

            // Metadata
            $table->unsignedBigInteger('created_by')->nullable()->comment('Created by user ID');
            $table->unsignedBigInteger('updated_by')->nullable()->comment('Updated by user ID');
            $table->unsignedBigInteger('deleted_by')->nullable()->comment('Deleted by user ID');

            $table->timestamps();
            $table->softDeletes('deleted_at', precision: 0)->comment('Soft delete timestamp');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('raw_employees');
    }
};
