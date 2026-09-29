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
        Schema::create('prescriptions', function (Blueprint $table) {
            $table->id('prescription_id');
            $table->unsignedBigInteger('record_id');
            $table->unsignedBigInteger('patient_id');
            $table->string('medication_name');
            $table->string('dosage');
            $table->string('frequency');
            $table->date('start_date');
            $table->date('end_date');
            $table->timestamps();

            // Relationship
            $table->foreign('record_id')
                ->references('record_id')
                ->on('medical_records')
                ->onDelete('cascade');

            $table->foreign('patient_id')
                ->references('patient_id')
                ->on('patient')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prescriptions');
    }
};
