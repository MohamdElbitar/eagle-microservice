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
                Schema::create('customers', function (Blueprint $table) {

                    $table->id();
                    $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');

                    $table->string('name');

                    $table->string('country')
                    ->nullable();

                    $table->string('city')
                            ->nullable();


                    $table->string('address')
                            ->nullable();


                    $table->enum('status', ['active', 'inactive', 'suspended'])
                            ->default('active');

                    $table->foreignId('created_by')
                    ->nullable()
                    ->constrained('users')
                    ->onDelete('set null');

                    $table->string('currency')
                        ->nullable();

                    $table->string('cr', 50)
                        ->unique()
                        ->nullable();

                    $table->string('vat_id', 50)
                            ->unique()
                            ->nullable();

                    $table->string('license', 50)->nullable();

                    $table->softDeletes();
                    $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
