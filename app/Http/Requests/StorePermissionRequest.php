<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePermissionRequest extends FormRequest
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
    // public function rules(): array
    // {
    //     return [
    //         'permission_key' => 'required|string|unique:permissions,permission_key',
    //         'description' => 'nullable|string',
    //     ];
    // }
    public function rules(): array
    {
        $allPermissions = collect(config('permissions'))
            ->flatten()
            ->unique()
            ->values()
            ->all();

        // return [
        //     'role' => [
        //         'required',
        //         'string',
        //         Rule::in([
        //             'doctor',
        //             'accountant',
        //             'pharmacy',
        //             'receptionist',
        //         ]),
        //     ],

        //     'permissions' => [
        //         'required',
        //         'array',
        //         'min:1',
        //     ],

        //     'permissions.*' => [
        //         'required',
        //         'string',
        //         'distinct',
        //         Rule::in($allPermissions),
        //     ],
        // ];
        return [
            'staff_id' => ['required', 'string'],
            'permissions' => ['sometimes', 'array'],
            'permissions.*' => [
                'required',
                'string',
                'distinct',
                Rule::in($allPermissions),
            ],
        ];
    }
}
