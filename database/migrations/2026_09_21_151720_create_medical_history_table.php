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
        Schema::create('medical_history', function (Blueprint $table) {
            $table->id('history_id');
            $table->unsignedBigInteger('patient_id');
            $table->text('past_diseases');
            $table->text('previous_surgeries');
            $table->text('allergies');
            $table->text('chromic_conditions');
            $table->dateTime('last_updated');
            $table->timestamps();

            // relationship
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
        Schema::dropIfExists('medical_history');
    }
};
