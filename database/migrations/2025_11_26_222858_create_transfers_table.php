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
        Schema::create('transfers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_number');
            $table->unsignedBigInteger('current_location_id');
            $table->unsignedBigInteger('current_department_id');
            $table->unsignedBigInteger('current_designation_id');
            $table->text('native_place')->nullable();
            $table->text('current_place')->nullable();
            $table->boolean('is_spouse_case')->default(false);
            $table->unsignedBigInteger('spouse_employee_number')->nullable();
            $table->unsignedBigInteger('spouse_employee_location_id')->nullable();
            $table->text('reason')->nullable();
            $table->text('remarks')->nullable();
            $table->boolean('is_renewed')->nullable();
            $table->date('last_renewed_at')->nullable();
            $table->boolean('is_expired')->default(false);
            $table->boolean('active_only')
                ->nullable()
                ->storedAs("(CASE WHEN is_expired = 0 THEN 1 ELSE NULL END)");

            // Approval workflow
            $table->unsignedBigInteger('hod_approver_employee_number')->nullable();
            $table->timestamp('hod_approved_at')->nullable();
            $table->text('hod_remarks')->nullable();

            $table->unsignedBigInteger('psc_approver_employee_number')->nullable();
            $table->timestamp('psc_approved_at')->nullable();
            $table->text('psc_remarks')->nullable();

            // Status management
            $table->enum('status', config('constants.app.request.transfer.STATUS'))->default(config('constants.app.request.transfer.STATUS.REQUESTED'));
            $table->enum('type', config('constants.app.request.transfer.TYPE'))->default(config('constants.app.request.transfer.STATUS.FRESH'));

            $table->timestamp('cancelled_at')->nullable();
            $table->string('cancellation_reason')->nullable();

            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();

            // Indexes
            $table->index('employee_number');
            $table->index('status');
            $table->index(['employee_number', 'status']);

            // Foreign keys
            $table->foreign('employee_number')
                ->references('employee_number')
                ->on('employees')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->foreign('current_location_id')
                ->references('id')
                ->on('locations')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->foreign('current_department_id')
                ->references('id')
                ->on('departments')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->foreign('current_designation_id')
                ->references('id')
                ->on('designations')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->foreign('spouse_employee_number')
                ->references('employee_number')
                ->on('employees')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->foreign('spouse_employee_location_id')
                ->references('id')
                ->on('locations')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->unique(['employee_number', 'active_only']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfers');
    }
};
