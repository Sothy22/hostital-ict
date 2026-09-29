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
        Schema::create('lab_tests', function (Blueprint $table) {
            $table->id('test_id');
            $table->foreignId('staff_id')
                  ->constrained('staff', 'staff_id')
                  ->onDelete('cascade');
             $table->foreignId('record_id')
                  ->constrained('medical_records', 'record_id')
                  ->onDelete('cascade');
            $table->foreignId('patient_id')
                  ->constrained('patients', 'patient_id')
                  ->onDelete('cascade');
            $table->string('test_name');
            $table->date('test_date');
            $table->text('result');
            $table->enum('status', [
                'Pending',
                'In Progress',
                'Completed'
            ])->default('Pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lab_tests');
    }
};
