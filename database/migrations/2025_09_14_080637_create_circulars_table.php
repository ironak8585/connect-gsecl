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
        Schema::create('circulars', function (Blueprint $table) {
            $table->id();

            // Foreign key references with Restrict on Delete and Cascade on Update
            $table->foreignId('company_id')
                ->constrained('companies')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->foreignId('department_id')
                ->nullable()
                ->constrained('departments')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->foreignId('category_id')
                ->nullable()
                ->constrained('circular_categories')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            // Core Details
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('circular_number')->nullable()->unique();

            // File Details
            // $table->enum('file_type', array_keys(config('constants.master.FILE_TYPES')))->default('PDF');
            $table->string('attachment');

            // Dates
            $table->date('issue_date');
            $table->date('effective_date')->nullable();
            $table->date('expiry_date')->nullable();

            // Timestamps
            $table->timestamp('published_at')->nullable();

            // Workflow & Access
            $table->enum('status', array_keys(config('constants.master.CIRCULAR_STATUS')))->default(config('constants.master.CIRCULAR_STATUS.PUBLISHED'));
            $table->enum('visibility', array_keys(config('constants.master.CIRCULAR_VISIBILITY')))->default('INTERNAL');

            // Audience (all or specific)
            $table->boolean('all_locations')->default(true); // true = applies everywhere
            $table->json('audience')->nullable(); // optional extra targeting

            // Users (Workflow Actors)
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->unsignedBigInteger('published_by')->nullable();

            // Tracking
            $table->unsignedBigInteger('views_count')->default(0);
            $table->unsignedBigInteger('download_count')->default(0);
            $table->boolean('is_active')->default(true);

            // Userstamps
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();

            // Timestamps
            $table->timestamps();
            $table->softDeletes();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('circulars');
    }
};
