<?php

namespace App\Http\Requests\Master;

use Illuminate\Foundation\Http\FormRequest;

class StoreCoreDepartmentRequest extends FormRequest
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
        return auth()->user()->can('master_core_departments_manage');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'unique:core_departments,name'],
        ];
    }
}
