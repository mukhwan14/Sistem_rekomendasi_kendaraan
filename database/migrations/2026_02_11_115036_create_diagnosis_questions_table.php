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
        Schema::create('diagnosis_questions', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // e.g., 'oil_condition'
            $table->string('question'); // e.g., 'Bagaimana kondisi oli mesin?'
            $table->string('type')->default('select'); // select, number, boolean
            $table->json('options')->nullable(); // [{"value": "bad", "label": "Buruk"}, ...]
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diagnosis_questions');
    }
};
