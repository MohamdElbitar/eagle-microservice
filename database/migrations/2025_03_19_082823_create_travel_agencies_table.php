<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('travel_agencies', function (Blueprint $table) {

            $table->id();

            $table->string('company_name')
                    ->unique();

            $table->string('email')
                    ->unique();

            $table->string('iate_code')
                    ->unique();

            $table->enum('status', ['pending', 'active', 'suspended'])
                    ->default('pending');

            $table->text('description')
                    ->nullable();

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('travel_agency_id')->nullable()->constrained()->nullOnDelete();
        });
    }

    public function down(): void {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['travel_agency_id']);
            $table->dropColumn('travel_agency_id');
        });

        Schema::dropIfExists('travel_agencies');
    }
};
