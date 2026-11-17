<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class DoctorSchedule extends Model
{
    protected $connection = 'mongodb';

    protected $collection = 'doctor_schedules';

    protected $fillable = [
        'doctor_id',
        'department_id',
        'work_date',
        'start_time',
        'end_time',
        'break_start',
        'break_end',
        'duration_minutes',
        'status',
        'rejection_reason',
        'reviewed_by',
        'reviewed_at',
    ];

    protected $casts = [
        'reviewed_at' => 'datetime',
    ];

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id', '_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', '_id');
    }
}
