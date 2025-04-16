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
        Schema::table('travel_agencies', function (Blueprint $table) {
            //
            $table->foreignId('plan_id')->constrained()->onDelete('cascade'); // Foreign key for Plan

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('travel_agencies', function (Blueprint $table) {
            //
        });
    }
};
