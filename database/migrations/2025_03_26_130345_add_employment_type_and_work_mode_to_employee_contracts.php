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
        Schema::table('employee_contracts', function (Blueprint $table) {
            //
            $table->enum('employment_type', ['full-time', 'part-time'])->default('full-time')->after('status');
            $table->enum('work_mode', ['hybrid', 'remote', 'onsite'])->default('onsite')->after('employment_type');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employee_contracts', function (Blueprint $table) {
            //
        });
    }
};
