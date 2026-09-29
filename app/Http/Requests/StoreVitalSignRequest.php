<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreVitalSignRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'patient_id' => 'required',
            'staff_id' => 'required',

            'temperature' => 'required|numeric',
            'blood_pressure' => 'required|string',

            'heart_rate' => 'required|integer',
            'respiratory_rate' => 'required|integer',

            'oxygen_saturation' => 'required|numeric',
            'weight' => 'required|numeric',
            'height' => 'required|numeric',

            'recorded_at' => 'required|date',
        ];
    }
}
