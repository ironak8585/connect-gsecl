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
        Schema::create('retired_employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('locations')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('location_id')->constrained('locations')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('dispensary_id')->constrained('dispensaries')->cascadeOnUpdate()->restrictOnDelete();
            $table->unsignedBigInteger('employee_number');
            
            $table->integer('employee_number')->constrained('locations')->cascadeOnUpdate()->restrictOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('retired_employees');
    }
};
