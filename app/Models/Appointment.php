<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Appointment extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'appointments';

    protected $fillable = [
        'patient_id',
        'staff_id',
        // 'department_id',
        'appointment_date',
        'purpose',
        'notes',
        'status'
    ];

    protected $casts = [
        'appointmetn_date' => 'date',
    ];

    public function patient() {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function staff()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }
}
