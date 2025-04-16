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
        Schema::create('customer_markups', function (Blueprint $table) {

            $table->id();

            $table->foreignId('item_type_id')
                    ->constrained()
                    ->cascadeOnDelete();

            $table->foreignId('customer_id')
                    ->constrained()
                    ->cascadeOnDelete();

            $table->decimal('markup', 10, 2)
                    ->default(0);

            $table->string('currency', 3)
                    ->nullable();

            $table->enum('value_type', ['amount', 'percentage']);

            $table->timestamps();

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_markups');
    }
};
