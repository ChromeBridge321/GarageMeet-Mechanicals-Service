<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePositionRequest extends FormRequest
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
            'name' => 'required|string|max:60',
            'mechanical_workshops_id' => 'required|exists:mechanical_workshops,id',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'The position name is required.',
            'name.max' => 'The position name may not be greater than 60 characters.',
            'mechanical_workshops_id.required' => 'The mechanical workshop ID is required.',
            'mechanical_workshops_id.exists' => 'The selected mechanical workshop does not exist.',
        ];
    }
}
