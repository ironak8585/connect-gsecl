<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('eurja_departments', function (Blueprint $table) {
            $table->id();
            $table->string('master', 255);
            $table->string('name', 255);
            $table->string('code', 16);
            $table->string('location_slug', 16);
            $table->enum('type', array_keys(Config::get('constants.master.DEPARTMENT.TYPE', [])));

            // Userstamps
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();

            // Timestamps
            $table->timestamps();
            $table->softDeletes('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eurja_departments');
    }
};
