<?php

namespace App\Http\Requests\Master;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreSubDepartmentRequest extends FormRequest
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

        // Check if the user has permission to create the record
        return auth()->user()->can('master_sub_departments_manage');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'core_department_id' => ['required', 'exists:core_departments,id'],

            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('sub_departments')
                    ->where('core_department_id', $this->core_department_id),
            ],

            'slug' => ['nullable', 'string', 'max:32'],

            // 'type' => [
            //     'required',
            //     'in:' . implode(',', array_keys(config('constants.master.DEPARTMENT.TYPE')))
            // ],
        ];
    }
}
