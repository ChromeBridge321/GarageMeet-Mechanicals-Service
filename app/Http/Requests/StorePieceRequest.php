<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePieceRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'mechanical_workshops_id' => 'required|exists:mechanical_workshops,id',
            'price' => 'required|numeric|min:0',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'The piece name is required.',
            'name.max' => 'The piece name may not be greater than 255 characters.',
            'mechanical_workshops_id.required' => 'The mechanical workshop ID is required.',
            'mechanical_workshops_id.exists' => 'The selected mechanical workshop does not exist.',
            'price.required' => 'The piece price is required.',
            'price.numeric' => 'The piece price must be a number.',
            'price.min' => 'The piece price must be greater than or equal to 0.',
        ];
    }
}
