<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class MedicalHistory extends Model
{
    protected $connection = 'mongodb';
    protected $collection = "medical_history";
    protected $fillable = [
        'patient_id',
        'past_diseases',
        'previous_surgeries',
        'allergies',
        'chronic_conditions',
        'last_updated',
    ];

    public function patient() {
        return $this->belongsTo(Patient::class, 'patient_id');
    }
}
