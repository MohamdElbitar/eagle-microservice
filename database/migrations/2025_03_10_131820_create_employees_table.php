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
        Schema::create('employees', function (Blueprint $table) {

            $table->id();
            $table->string('code')->unique();

            $table->string('first_name');

            $table->string('last_name');

            $table->string('mobile')
                    ->nullable();

            $table->string('work_email')
                    ->nullable()
                    ->unique();

            $table->string('job_position')
                    ->nullable();

            $table->foreignId('direct_manager')
                    ->nullable()
                    ->constrained('employees')
                    ->nullOnDelete();

            $table->foreignId('department_id')
                    ->nullable()
                    ->constrained()
                    ->nullOnDelete();

            $table->foreignId('user_id')
                    ->nullable()
                    ->constrained()
                    ->onDelete('cascade');

            $table->foreignId('created_by')
                    ->nullable()
                    ->constrained('users')
                    ->onDelete('set null');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
