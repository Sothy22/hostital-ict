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
        Schema::create('emergency_contacts', function (Blueprint $table) {
            $table->id('contact_id');
            $table->unsignedBigInteger('patient_id');
            $table->string('contact_name');
            $table->string('contact_phone');
            $table->string('relationship');
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
        Schema::dropIfExists('emergency_contacts');
    }
};
