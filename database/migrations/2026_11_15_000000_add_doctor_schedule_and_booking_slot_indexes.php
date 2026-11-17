<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $connection = DB::connection('mongodb');

        $connection->getCollection('doctor_schedules')->createIndex(
            ['doctor_id' => 1, 'work_date' => 1],
            ['name' => 'doctor_schedules_doctor_date_unique', 'unique' => true]
        );

        $connection->getCollection('appointments')->createIndex(
            ['booking_slot_key' => 1],
            ['name' => 'appointments_booking_slot_key_unique', 'unique' => true, 'sparse' => true]
        );
    }

    public function down(): void
    {
        $connection = DB::connection('mongodb');
        $connection->getCollection('doctor_schedules')->dropIndex('doctor_schedules_doctor_date_unique');
        $connection->getCollection('appointments')->dropIndex('appointments_booking_slot_key_unique');
    }
};
