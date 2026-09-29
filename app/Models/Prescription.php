<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Prescription extends Model
{
     protected $connection = 'mongodb';
    protected $collection = 'patients';

    protected $fillable = [
        'record_id',
        'patient_id',
        'medication_name',
        'dosage',
        'frequency',
        'start_date',
        'end_date'
    ];

    public function patient() {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

     public function medicalRecord() {
        return $this->belongsTo(MedicalRecord::class, 'record_id');
    }
}
