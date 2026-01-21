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
        Schema::create('transfer_preferences_bkp', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transfer_id')
                ->constrained('transfers')
                ->onDelete('cascade');
            $table->unsignedBigInteger('location_id');
            $table->tinyInteger('preference')->comment('1=First, 2=Second, 3=Third');

            $table->enum('request_type', [
                'fresh',    // First time creation
                'renewed',  // Annual December renewal
                'updated'   // Mid-year updates
            ])->default('fresh');

            $table->boolean('is_active')->default(true);

            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();

            // Unique constraint: one transfer can have only one preference level
            $table->unique(['transfer_id', 'preference']);

            // Unique constraint: same location can't be selected multiple times
            $table->unique(['transfer_id', 'location_id']);

            $table->index(['transfer_id', 'is_active']);

            $table->foreign('location_id')
                ->references('id')
                ->on('locations')
                ->onDelete('restrict');
        });

        // Complete history/audit trail
        Schema::create('transfer_preferences_history_bkp', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transfer_id')
                ->constrained('transfers')
                ->onDelete('cascade');
            $table->unsignedBigInteger('transfer_preference_id')->nullable();
            $table->unsignedBigInteger('location_id');
            $table->tinyInteger('preference');

            $table->enum('action_type', [
                'created',
                'updated',
                'renewed',
                'cancelled',
                'deleted'
            ]);

            $table->enum('request_type', [
                'fresh',
                'renewed',
                'updated'
            ])->nullable();

            $table->timestamp('renewed_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->text('remarks')->nullable();

            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();

            $table->index('transfer_id');
            $table->index('transfer_preference_id');
            $table->index('action_type');

            $table->foreign('location_id')
                ->references('id')
                ->on('locations')
                ->onDelete('restrict');
        });

        // Track actual transfer operations when approved
        Schema::create('transfer_operations_bkp', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transfer_id')
                ->constrained('transfers')
                ->onDelete('restrict');
            $table->unsignedBigInteger('employee_number');
            $table->unsignedBigInteger('from_location_id');
            $table->unsignedBigInteger('to_location_id');
            $table->unsignedBigInteger('from_department_id');
            $table->unsignedBigInteger('to_department_id')->nullable();

            $table->date('effective_date');
            $table->date('relieving_date')->nullable();
            $table->date('joining_date')->nullable();

            $table->text('remarks')->nullable();

            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();

            $table->index('employee_number');
            $table->index('effective_date');

            $table->foreign('employee_number')
                ->references('employee_number')
                ->on('employees')
                ->onDelete('cascade');

            $table->foreign('from_location_id')
                ->references('id')
                ->on('locations')
                ->onDelete('restrict');

            $table->foreign('to_location_id')
                ->references('id')
                ->on('locations')
                ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfer_operations_bkp');
        Schema::dropIfExists('transfer_preferences_history_bkp');
        Schema::dropIfExists('transfer_preferences_bkp');
    }
};
