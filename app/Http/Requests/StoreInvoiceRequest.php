<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInvoiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'patient_id' => 'required',
            'appointment_id' => 'required',

            'invoice_number' => 'required|string',

            'total_amount' => 'required|numeric',
            'discount' => 'required|numeric',
            'tax' => 'required|numeric',
            'final_amount' => 'required|numeric',

            'status' => 'required|string',

            'issued_at' => 'required|date',
            'due_date' => 'required|date',
        ];
    }
}
