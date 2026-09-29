<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class VitalSign extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'vital_signs';

    protected $fillable = [
        'patient_id',
        'staff_id',
        'temperature',
        'blood_pressure',
        'heart_rate',
        'respiratory_rate',
        'oxygen_saturation',
        'weight',
        'height',
        'recorded_at',
    ];

    public function patient()
    {
        return $this->belongsTo(
            Patient::class,
            'patient_id'
        );
    }

    public function staff()
    {
        return $this->belongsTo(
            User::class,
            'staff_id'
        );
    }
}
