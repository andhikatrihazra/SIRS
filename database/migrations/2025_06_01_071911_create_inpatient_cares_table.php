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
        Schema::create('inpatient_cares', function (Blueprint $table) {
            $table->id();
            $table->string('patient_medical_record_number');
            $table->string('room_code');
            $table->date('admission_date');
            $table->date('discharge_date')->nullable();
            $table->timestamps();

            $table->foreign('patient_medical_record_number')->references('medical_record_number')->on('patients')->onDelete('cascade');
            $table->foreign('room_code')->references('room_code')->on('rooms')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inpatient_cares');
    }
};
