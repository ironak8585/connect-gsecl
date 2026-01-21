<?php

namespace App\Http\Requests\Emp\Request\Transfer;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use App\Models\Employee\MasterEmployee;
use App\Models\App\Request\Transfer;

class BKP_StoreTransferRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Only authenticated users can create transfer requests
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'reason' => [
                'required',
                'string',
                'min:20',
                'max:1000',
            ],
            'preference_1' => [
                'required',
                'exists:locations,id',
                'different:preference_2',
                'different:preference_3',
            ],
            'preference_2' => [
                'required',
                'exists:locations,id',
                'different:preference_1',
                'different:preference_3',
            ],
            'preference_3' => [
                'required',
                'exists:locations,id',
                'different:preference_1',
                'different:preference_2',
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
            'reason.required' => 'Please provide a reason for your transfer request.',
            'reason.min' => 'Reason must be at least 20 characters long.',
            'reason.max' => 'Reason cannot exceed 1000 characters.',

            'preference_1.required' => 'First preference is required.',
            'preference_1.exists' => 'Selected first preference location is invalid.',
            'preference_1.different' => 'First preference must be different from other preferences.',

            'preference_2.required' => 'Second preference is required.',
            'preference_2.exists' => 'Selected second preference location is invalid.',
            'preference_2.different' => 'Second preference must be different from other preferences.',

            'preference_3.required' => 'Third preference is required.',
            'preference_3.exists' => 'Selected third preference location is invalid.',
            'preference_3.different' => 'Third preference must be different from other preferences.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'preference_1' => 'first preference',
            'preference_2' => 'second preference',
            'preference_3' => 'third preference',
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $employee = MasterEmployee::where('employee_number', auth()->user()->employee_number)->first();

            if (!$employee) {
                $validator->errors()->add('employee', 'Employee record not found.');
                return;
            }

            // Check if employee already has an active transfer request
            $existingTransfer = Transfer::where('employee_number', $employee->employee_number)
                ->whereIn('status', ['draft', 'requested'])
                ->exists();

            if ($existingTransfer) {
                $validator->errors()->add(
                    'transfer',
                    'You already have an active transfer request. Please cancel or wait for approval before creating a new one.'
                );
            }

            // Get all preference values
            $preferences = [
                $this->input('preference_1'),
                $this->input('preference_2'),
                $this->input('preference_3'),
            ];

            // Check if current location is selected in any preference
            if (in_array($employee->location_id, $preferences)) {
                $validator->errors()->add(
                    'current_location',
                    'You cannot select your current location as a transfer preference.'
                );
            }

            // Get previously transferred locations
            $transferredLocations = DB::table('transfer_operations')
                ->where('employee_number', $employee->employee_number)
                ->pluck('to_location_id')
                ->toArray();

            // Check if any selected preference was a previously transferred location
            $invalidSelections = array_intersect($preferences, $transferredLocations);

            if (!empty($invalidSelections)) {
                $locationNames = DB::table('locations')
                    ->whereIn('id', $invalidSelections)
                    ->pluck('name')
                    ->toArray();

                $validator->errors()->add(
                    'transferred_locations',
                    'You cannot select the following location(s) as you have been previously transferred there: ' .
                    implode(', ', $locationNames)
                );
            }

            // Verify all three preferences are unique (additional check)
            $uniquePreferences = array_unique(array_filter($preferences));
            if (count($uniquePreferences) !== 3) {
                $validator->errors()->add(
                    'duplicate_preferences',
                    'All three location preferences must be different from each other.'
                );
            }
        });
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation(): void
    {
        // Trim and sanitize the reason field
        if ($this->has('reason')) {
            $this->merge([
                'reason' => trim($this->input('reason')),
            ]);
        }

        // Convert preference values to integers
        $this->merge([
            'preference_1' => $this->input('preference_1') ? (int) $this->input('preference_1') : null,
            'preference_2' => $this->input('preference_2') ? (int) $this->input('preference_2') : null,
            'preference_3' => $this->input('preference_3') ? (int) $this->input('preference_3') : null,
        ]);
    }

    /**
     * Get validated data with employee information
     *
     * @return array
     */
    public function validatedWithEmployee(): array
    {
        $validated = $this->validated();

        $employee = MasterEmployee::where('employee_number', auth()->user()->employee_number)->first();

        return array_merge($validated, [
            'employee_number' => $employee->employee_number,
            'current_location_id' => $employee->location_id,
            'current_department_id' => $employee->department_id,
        ]);
    }
}