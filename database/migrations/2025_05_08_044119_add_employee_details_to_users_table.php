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
        Schema::table('users', function (Blueprint $table) {
            //
            // make email nullable
            $table->string('email')->nullable()->change();

            $table->unsignedBigInteger('employee_number')->unique()->after('name');
            $table->unsignedBigInteger('company_id')->nullable()->after('employee_number');
            $table->unsignedBigInteger('location_id')->nullable()->after('company_id');
            $table->unsignedBigInteger('department_id')->nullable()->after('location_id');

            $table->boolean('validate_through_eUrja')->default(false)->after('remember_token');
            $table->boolean('is_active')->default(false)->after('validate_through_eUrja');
            $table->enum('status', Config::get('constants.admin.USER.STATUS'))->after('is_active');
            $table->timestamp('last_eUrja_synced_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
