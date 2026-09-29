<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreLabTestRequest extends FormRequest
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
            'staff_id' => 'required|string',
            'record_id' => 'required|string',
            'patient_id' => 'required|string',
            'test_name' => 'required|string|max:100',
            'test_date' => 'required|date',
            'result' => 'required|string',
            'status' => ['required', 'in:Pending,In Progress,Completed'],
        ];
    }
}
