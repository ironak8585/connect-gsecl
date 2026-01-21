<?php

namespace App\Http\Requests\Content\Circular;

use Illuminate\Foundation\Http\FormRequest;

class StoreCircularRequest extends FormRequest
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
        return auth()->user()->can('app_content_circular_manage');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // Foreign keys
            'department_id' => ['nullable', 'exists:departments,id'],
            'category_id' => ['nullable', 'exists:circular_categories,id'],

            // Core details
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'circular_number' => ['required', 'string', 'max:100', 'unique:circulars,circular_number'],

            // File details
            'attachment' => [
                'required',
                'file',
                'mimes:pdf',
                'max:' . config('constants.system.SIZE.PDF.5MB'),
            ],

            // Dates
            'issue_date' => ['required', 'date'],
            'effective_date' => ['nullable', 'date', 'after_or_equal:issue_date'],
            'published_at' => [
                'required',
                'date',
                'after_or_equal:today',
            ],
            'expiry_date' => ['nullable', 'date', 'after_or_equal:effective_date'],

            // Workflow & Access
            'status' => ['required', 'in:' . implode(',', array_keys(config('constants.master.CIRCULAR_STATUS')))],
            'visibility' => ['required', 'in:' . implode(',', array_keys(config('constants.master.CIRCULAR_VISIBILITY')))],

            // Audience
            'all_locations' => ['nullable', 'boolean'],
            'audience' => ['nullable', 'array'],
            'audience.*' => ['integer', 'exists:locations,id'],

            // Workflow actors (optional, can be auto-filled)
            'approved_by' => ['nullable', 'exists:users,id'],
            'published_by' => ['nullable', 'exists:users,id'],

            // Tracking & system flags
            'views_count' => ['nullable', 'integer', 'min:0'],
            'download_count' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['boolean'],
        ];
    }

    public function messages()
    {
        $sizeKb = config('constants.system.SIZE.PDF.5MB');
        $sizeMb = $sizeKb / 1024;

        return [
            'attachment.max' => "The attachment must not be greater than {$sizeMb} MB.",
            'attachment.mimes' => 'Only PDF files are allowed for the attachment.',
        ];
    }
}
