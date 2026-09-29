<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id('invoice_id');

            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('appointment_id');

            $table->string('invoice_number')->unique();

            $table->decimal('total_amount', 12, 2);
            $table->decimal('discount', 12, 2);
            $table->decimal('tax', 12, 2);
            $table->decimal('final_amount', 12, 2);

            $table->string('status');

            $table->dateTime('issued_at');
            $table->date('due_date');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
