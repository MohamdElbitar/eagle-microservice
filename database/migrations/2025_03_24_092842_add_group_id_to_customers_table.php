<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->foreignId('group_id')->nullable()->constrained('customer_groups')->onDelete('set null')->after('user_id');
            $table->foreignId('salesperson')->nullable()->constrained('employees')->nullOnDelete();
        });
    }

    public function down()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropForeign(['group_id']);
            $table->dropForeign(['salesperson']);
            $table->dropColumn(['salesperson']);
            $table->dropColumn('group_id');
        });
    }

};
