<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('lead_sources', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // Example: Facebook, LinkedIn, Google Ads
            $table->timestamps();
        });

        // Add lead_source_id to customers table
        Schema::table('customers', function (Blueprint $table) {
            $table->foreignId('lead_source_id')->nullable()->constrained('lead_sources')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropForeign(['lead_source_id']);
            $table->dropColumn('lead_source_id');
        });

        Schema::dropIfExists('lead_sources');
    }
};
