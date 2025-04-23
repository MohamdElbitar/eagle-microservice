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
        Schema::create('employee_contracts', function (Blueprint $table) {
            $table->id();

            $table->foreignId('employee_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('national_number')->unique();
            $table->string('religion')->nullable();
            $table->string('nationality', 3)->nullable()->index();

            $table->string('address')->nullable();

            $table->decimal('salary', 10, 2);

            $table->date('contract_start_date')->nullable();
            $table->date('contract_end_date')->nullable();

            $table->enum('status', ['active', 'expired', 'terminated'])->default('active');

            $table->softDeletes();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_contracts');
    }
};
