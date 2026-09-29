<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Invoice extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'invoices';

    protected $fillable = [
        'patient_id',
        'appointment_id',
        'invoice_number',
        'total_amount',
        'discount',
        'tax',
        'final_amount',
        'status',
        'issued_at',
        'due_date',
    ];

    public function patient()
    {
        return $this->belongsTo(
            Patient::class,
            'patient_id'
        );
    }

    public function appointment()
    {
        return $this->belongsTo(
            Appointment::class,
            'appointment_id'
        );
    }

    // public function payments()
    // {
    //     return $this->hasMany(
    //         Payment::class,
    //         'invoice_id'
    //     );
    // }

}
