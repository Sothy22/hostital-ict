<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AppointmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'patient_id' => 'required',
            'staff_id' => 'required',
            // 'department_id' => 'required',
            'appointment_date' => 'required|date',
            'purpose' => 'required|string|max:200',
            'status' => 'required|in:Scheduled,Completed,Cancelled',
            'notes' => 'nullable|string',
        ];
    }
}
