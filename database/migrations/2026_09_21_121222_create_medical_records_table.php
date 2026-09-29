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
        Schema::create('medical_records', function (Blueprint $table) {
            $table->id('record_id');
            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('staff_id');
            $table->dateTime('visit_date');
            $table->text('diagnosis')->nullable();
            $table->text('treatment_notes')->nullable();
            $table->date('follow_up_date')->nullable();
            $table->timestamps();

            // Relationships
            $table->foreign('patient_id')
                  ->references('patient_id')
                  ->on('patients')
                  ->onDelete('cascade');

            $table->foreign('staff_id')
                  ->references('staff_id')
                  ->on('staff')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_records');
    }
};
