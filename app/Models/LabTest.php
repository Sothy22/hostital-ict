<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class LabTest extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'lab_tests';
    protected $fillable = [
        'staff_id',
        'record_id',
        'patient_id',
        'test_name',
        'test_date',
        'result',
        'status',
    ];

    public function staff() {
        return $this->belongsTo(User::class, 'staff_id');
    }
    public function patient() {
        return $this->belongsTo(Patient::class, 'patient_id');
    }
    public function record() {
        return $this->belongsTo(MedicalRecord::class, 'record_id');
    }
}
