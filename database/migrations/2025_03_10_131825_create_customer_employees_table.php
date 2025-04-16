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
        Schema::create('customer_employees', function (Blueprint $table) {

            $table->id();

            $table->foreignId('user_id')
                    ->constrained()
                    ->cascadeOnDelete();

            $table->foreignId('customer_id')
                    ->constrained()
                    ->cascadeOnDelete();

            $table->foreignId('department_id')
                    ->constrained()
                    ->cascadeOnDelete();

            $table->string('first_name');
            $table->string('last_name') ;
            $table->string('mobile')->nullable();
            $table->string('phone')->nullable();
            $table->string('email');

            $table->string('role_in_customer');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_employees');
    }
};
