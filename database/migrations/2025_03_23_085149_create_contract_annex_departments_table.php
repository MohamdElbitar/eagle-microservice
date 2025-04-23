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
        Schema::create('contract_annex_departments', function (Blueprint $table) {

            $table->id();

            $table->foreignId('contract_id')
                    ->constrained()
                    ->onDelete('cascade');

            $table->unsignedBigInteger('department_manager_id')
                    ->nullable();

            $table->unsignedBigInteger('department_in_charge_id')
                    ->nullable();

            $table->foreign('department_manager_id')
                    ->references('id')
                    ->on('employees')
                    ->cascadeOnDelete();

            $table->foreign('department_in_charge_id')
                    ->references('id')
                    ->on('employees')
                    ->cascadeOnDelete();

            $table->enum('party-type', ['first-party', 'second-party']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contract_annex_departments');
    }
};
