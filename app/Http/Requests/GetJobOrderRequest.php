<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetJobOrderRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'search'   => 'nullable|string|max:100',
            'sort_by'  => 'nullable|in:created_at,job_number,customer_name,status_id,driver_id',
            'sort_dir' => 'nullable|in:asc,desc',
            'per_page' => 'nullable|integer|min:1|max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'sort_by.in'  => 'Kolom sort tidak valid.',
            'sort_dir.in' => 'Arah sort harus asc atau desc.',
        ];
    }
}
