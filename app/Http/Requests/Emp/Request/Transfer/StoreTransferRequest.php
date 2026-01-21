<?php

namespace App\Http\Requests\Emp\Request\Transfer;

use Illuminate\Foundation\Http\FormRequest;

class StoreTransferRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // allow if user is SUPER_ADMIN or ADMIN
        if (auth()->user()->hasRole(['SUPER_ADMIN', 'ADMIN'])) {
            return true;
        }

        // Check if the user has permission to create circulars
        return auth()->user()->can('emp_request_transfer_manage');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'location_1' => [
                'required',
                'exists:locations,id',
                'different:location_2',
                'different:location_3',
            ],

            'location_2' => [
                'nullable',
                'exists:locations,id',
                'different:location_1',
                'different:location_3',
            ],

            'location_3' => [
                'nullable',
                'exists:locations,id',
                'different:location_1',
                'different:location_2',
            ],

            'native_place' => ['nullable', 'string', 'max:255'],
            'current_place' => ['nullable', 'string', 'max:255'],

            'reason' => ['nullable', 'string', 'max:1000'],
            'remarks' => ['nullable', 'string', 'max:255'],

            'is_spouse_case' => ['required', 'in:0,1'],

            // required only if is_spouse_case = 1
            'spouse_employee_number' => [
                'nullable',
                'required_if:is_spouse_case,1',
                'numeric',
                'exists:employees,employee_number',
            ],

            // required only if is_spouse_case = 1
            'spouse_employee_location_id' => [
                'nullable',
                'required_if:is_spouse_case,1',
                'integer',
                'exists:locations,id',
            ],
        ];
    }

    /**
     * Get custom validation messages
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'reason.max' => 'Reason cannot exceed 1000 characters.',

            'location_1.required' => 'At least one preference is required.',
            'location_1.exists' => 'Selected location is invalid.',
            'location_1.different' => 'First preference must be different from other preferences.',

            'location_2.exists' => 'Selected location is invalid.',
            'location_2.different' => 'Second preference must be different from other preferences.',

            'location_3.exists' => 'Selected location is invalid.',
            'location_3.different' => 'Third preference must be different from other preferences.',

            'is_spouse_case.required' => 'Spouse case selection in required.',

            'spouse_employee_number.required_if' => 'Spouse employee number is required if Spouse Case is selected Yes.',
            'spouse_employee_number.numeric' => 'Spouse employee number must be numeric value.',

            'spouse_employee_location.required_if' => 'Spouse employee location is required if Spouse Case is selected Yes.',
            'spouse_employee_location.exists' => 'Spouse employee location is invalid.',
        ];
    }
}
