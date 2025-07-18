<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePositionRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'positions_id' => 'required|exists:positions,positions_id',
            'name' => 'required|string|max:60',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'positions_id.required' => 'The position ID is required.',
            'positions_id.exists' => 'The selected position does not exist.',
            'name.required' => 'The position name is required.',
            'name.max' => 'The position name may not be greater than 60 characters.',
        ];
    }
}
