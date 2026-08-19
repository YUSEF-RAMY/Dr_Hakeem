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
        Schema::create('diagnoses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('patient_id_code')->nullable();
            $table->string('image_path');
            $table->string('predicted_class')->nullable();
            $table->string('predicted_label')->nullable();
            $table->decimal('confidence', 8, 6)->nullable();
            $table->string('risk_level')->default('low');
            $table->decimal('inference_time_ms', 10, 2)->nullable();
            $table->json('severity_analysis')->nullable();
            $table->boolean('tta_used')->default(false);
            $table->json('raw_response')->nullable();
            $table->string('status')->default('pending');
            $table->text('error_message')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'status']);
            $table->index('patient_id_code');
            $table->index('predicted_class');
            $table->index('risk_level');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diagnoses');
    }
};
