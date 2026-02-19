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
        Schema::table('daily_earnings', function (Blueprint $table) {
            $table->enum('status', ['active', 'used'])->default('active')->after('allocated_funds');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('daily_earnings', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
