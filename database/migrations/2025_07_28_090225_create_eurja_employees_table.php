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
        Schema::create('eurja_employees', function (Blueprint $table) {
            // $table->id();
            // $table->string('empno')->unique();
            $table->unsignedBigInteger('employee_number')->primary();
            $table->index('employee_number');
            
            $table->string('empname');
            $table->string('empdesig')->nullable();
            $table->string('empposition')->nullable();
            $table->string('empdepartment')->nullable();
            $table->string('emplocation')->nullable();
            $table->string('empclass', 10)->nullable();
            $table->string('empgender', 10)->nullable();
            $table->string('empcaste')->nullable();
            $table->date('dtjoin')->nullable();
            $table->date('dtjoincurrentplace')->nullable();
            $table->date('dtlasthighergrade')->nullable();
            $table->date('dtjoincurrentcadre')->nullable();
            $table->date('dtofbirth')->nullable();
            $table->string('empdisabled', 1)->nullable(); // Y/N
            $table->string('empcategory', 5)->nullable();
            $table->string('email')->nullable();
            $table->string('phone', 15)->nullable();
            $table->string('bloodgroup', 5)->nullable();
            $table->string('qualification')->nullable();
            $table->integer('age')->nullable();
            $table->integer('yearscurrentcadre')->nullable();
            $table->integer('yearscurrentplace')->nullable();
            $table->date('dtnextincrement')->nullable();
            $table->decimal('basic', 10, 2)->nullable();
            $table->string('personID')->nullable();
            $table->longText('imageData')->nullable();
            $table->string('inchargeDesignation')->nullable();
            $table->string('inchargeLocation')->nullable();
            $table->string('p_status', 20)->default('success');
            $table->text('p_errmsg')->nullable();
            $table->text('p_crmerrmsg')->nullable();
            $table->text('p_return_message')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eurja_employees');
    }
};
