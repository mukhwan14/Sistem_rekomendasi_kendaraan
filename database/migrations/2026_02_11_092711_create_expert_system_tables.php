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
        Schema::create('rules', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // R01, R02
            $table->string('name');
            $table->text('description')->nullable();
            $table->text('recommendation');
            $table->json('action_list')->nullable(); // ["Ganti Oli", "Cek Rem"]
            $table->integer('priority')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('rule_conditions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rule_id')->constrained('rules')->onDelete('cascade');
            $table->string('fact_variable'); // income, oil_condition
            $table->enum('operator', ['>', '<', '>=', '<=', '==', '!=']);
            $table->string('value');
            $table->enum('value_type', ['string', 'numeric', 'boolean']);
            $table->timestamps();
        });

        Schema::create('consultations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('vehicle_type')->nullable(); // Motor/Mobil
            $table->string('vehicle_brand')->nullable();
            $table->integer('vehicle_year')->nullable();
            $table->dateTime('consultation_date')->useCurrent();
            $table->json('input_facts'); // Snapshot of input
            $table->text('result_recommendation');
            $table->json('matched_rules')->nullable(); // Codes of rules triggered
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultations');
        Schema::dropIfExists('rule_conditions');
        Schema::dropIfExists('rules');
    }
};
