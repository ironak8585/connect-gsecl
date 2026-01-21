<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations. // This Departments refers to Location's Department
     */
    public function up(): void
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            // $table->unsignedBigInteger('company_id');
            // $table->unsignedBigInteger('location_id');
            $table->unsignedBigInteger('eurja_department_id');
            $table->unsignedBigInteger('sub_department_id');
            $table->string('name', 255);
            $table->enum('type', array_keys(Config::get('constants.master.DEPARTMENT.TYPE', [])));

            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();

            $table->timestamps();
            $table->softDeletes('deleted_at')->nullable();

            // Add the foreign key constraint.
            $table->foreign('eurja_department_id')
                ->references('id')
                ->on('eurja_departments')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            // Add the foreign key constraint.
            $table->foreign('sub_department_id')
                ->references('id')
                ->on('sub_departments')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            // Add the foreign key constraint.
            // $table->foreign('department_id')
            //     ->references('id')
            //     ->on('department_masters')
            //     ->onUpdate('cascade')
            //     ->onDelete('restrict');

            // Unique Composite 
            $table->unique(['sub_department_id', 'name', 'type']);
        });

        // Add relation with Locations
        // Schema::table('users', function (Blueprint $table) {
        //     // plant user relation with users
        //     $table->foreign('department_id')
        //         ->on('departments')
        //         ->references('id')
        //         ->onUpdate('cascade')
        //         ->onDelete('restrict');
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('departments');
    }
};
