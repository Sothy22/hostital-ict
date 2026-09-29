<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
class EmergencyContact extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'emergencyContact';
    protected $fillable = [
        'patient_id',
        'contact_name',
        'contact_phone',
        'relationship',
    ];
    public function patient () {
        return $this->belongsTo(Patient::class, 'patient_id');
    }
}
