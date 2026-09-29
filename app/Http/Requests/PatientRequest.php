<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PatientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
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
            'full_name' => 'required|string|max:100',
            'blood_group' => 'nullable|string|max:10',
            'dob' => 'required|date',
            'gender' => 'required|string|max:10',
            'phone' => 'required|string|max:15',
            'address' => 'nullable|string'
        ];
    }
}
