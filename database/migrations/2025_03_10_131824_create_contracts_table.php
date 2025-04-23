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
        Schema::create('contracts', function (Blueprint $table) {

            $table->id();
            $table->string('contract_number')->unique();

            $table->string('subject');

            $table->text('description')
                    ->nullable();

            $table->date('from_date');
            $table->date('to_date');

            $table->foreignId('customer_id') // second party
                    ->constrained('customers')
                    ->constrained()
                    ->onDelete('cascade');

            $table->timestamps();

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};
