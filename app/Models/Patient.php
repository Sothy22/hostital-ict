<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Patient extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'patients';

    protected $fillable = [
        'full_name',
        'dob',
        'gender',
        'phone',
        'address',
        'blood_group'
    ];

    protected $casts = [
         'dob' => 'date',
    ];

    public function appointments() {
        return $this->hasMany(Appointment::class, 'patient_id');
    }

    public function medical_record() {
        return $this->hasMany(MedicalRecord::class, 'patient_id');
    }

    public function medicalHistory() {
        return $this->hasMany(MedicalHistory::class, 'patient_id');
    }

    public function emergencyContact() {
        return $this->hasMany(EmergencyContact::class, 'patient_id');
    }

    public function prescription() {
        return $this->hasMany(Prescription::class, 'patient_id');
    }

    public function labTest () {
        return $this->hasMany(LabTest::class, 'patient_id');
    }

    public function vitalSign () {
        return $this->hasMany(VitalSign::class, 'patient_id');
    }
}
