<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class MedicalRecord extends Model
{
    protected $connetion = 'mongodb';
    protected $collection = 'medicalRecords';
    protected $fillable = [
        'patient_id',
        'staff_id',
        'visit_date',
        'diagnosis',
        'treatment_notes',
        'follow_up_date',
    ];

    protected $casts = [
        'visit_date' => 'datetime',
        'follow_up_date' => 'date',
    ];

    public function patient () {
        return $this->belongsTo(Patient::class, 'patient_id');
    }
    public function staff () {
        return $this->belongsTo(User::class, 'staff_id');
    }

    public function prescription() {
        return $this->hasMany(Prescription::class, 'record_id');
    }

    public function labTest () {
        return $this->hasMany(LabTest::class, 'record_id');
    }
}
