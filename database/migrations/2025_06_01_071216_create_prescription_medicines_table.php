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
        Schema::create('prescription_medicines', function (Blueprint $table) {
            $table->id();
            $table->string('prescription_code');
            $table->string('medicine_code');
            $table->integer('quantity');
            $table->string('dosage');
            $table->timestamps();

            $table->foreign('prescription_code')
                ->references('prescription_code')
                ->on('prescriptions')
                ->onDelete('restrict');  // update onDelete ke restrict

            $table->foreign('medicine_code')
                ->references('medicine_code')
                ->on('medicines')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prescription_medicines');
    }
};
