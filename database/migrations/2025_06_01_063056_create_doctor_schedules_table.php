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
        Schema::create('doctor_schedules', function (Blueprint $table) {
            $table->id();
            $table->string('doctor_license_number');
            $table->string('department_code');
            $table->string('day');
            $table->time('start_time');
            $table->time('end_time');
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('doctor_license_number')->references('license_number')->on('doctors')->onDelete('cascade');
            $table->foreign('department_code')->references('department_code')->on('departments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctor_schedules');
    }
};
