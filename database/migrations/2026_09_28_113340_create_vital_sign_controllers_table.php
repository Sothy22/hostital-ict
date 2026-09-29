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
        Schema::create('vital_sign_controllers', function (Blueprint $table) {
            $table->id('vital_id');

            $table->foreignId('patient_id')
                  ->constrained('patients', 'patient_id')
                  ->onDelete('cascade');
            $table->foreignId('staff_id')
                  ->constrained('staff', 'staff_id')
                  ->onDelete('cascade');

            $table->decimal('temperature', 5, 2);
            $table->string('blood_pressure');
            $table->integer('heart_rate');
            $table->integer('respiratory_rate');
            $table->decimal('oxygen_saturation', 5, 2);
            $table->decimal('weight', 6, 2);
            $table->decimal('height', 6, 2);

            $table->dateTime('recorded_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vital_signs');
    }
};
