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
        Schema::create('employees', function (Blueprint $table) {
            $table->unsignedBigInteger('employee_number')->primary();
            $table->foreignId('user_id')->constrained()->onUpdate('cascade')->onDelete('restrict');
            // $table->foreignId('eurja_employee_id')->constrained()->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('company_id')->constrained()->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('location_id')->constrained()->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('department_id')->constrained('departments')->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('designation_id')->constrained()->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('incharge_location_id')->nullable()->constrained('locations')->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('incharge_designation_id')->nullable()->constrained('designations')->onUpdate('cascade')->onDelete('restrict');

            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone', 15)->unique();
            $table->unsignedInteger('basic')->nullable();

            $table->boolean('disability')->default(false);

            $table->enum('category', array_keys(config('constants.admin.EMPLOYEE.CATEGORY')));
            $table->enum('gender', array_keys(config('constants.admin.EMPLOYEE.GENDER')));
            $table->enum('caste', array_keys(config('constants.admin.EMPLOYEE.CASTE')));
            $table->enum('bloodgroup', config('constants.admin.EMPLOYEE.BLOODGROUP'));
            $table->enum('status', config('constants.admin.EMPLOYEE.STATUS'))->default(config('constants.admin.EMPLOYEE.STATUS.ACTIVE'));

            $table->date('date_of_birth');
            $table->date('date_of_company_joining');
            $table->date('date_of_current_location_joining');
            $table->date('date_of_current_cadre_joining');
            $table->date('date_of_last_higher_grade')->nullable();
            $table->date('date_of_next_increment');

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
        Schema::dropIfExists('employees');
    }
};
