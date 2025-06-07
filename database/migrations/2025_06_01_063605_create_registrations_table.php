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
        Schema::create('registrations', function (Blueprint $table) {
            $table->string('registration_code')->primary();
            $table->string('patient_medical_record_number');
            $table->string('department_code');
            $table->enum('status', ['active', 'completed', 'canceled'])->default('active');
            $table->date('examination_date');
            $table->string('notes')->nullable();
            $table->date('registration_date');
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('patient_medical_record_number')->references('medical_record_number')->on('patients')->onDelete('cascade');
            $table->foreign('department_code')->references('department_code')->on('departments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};
