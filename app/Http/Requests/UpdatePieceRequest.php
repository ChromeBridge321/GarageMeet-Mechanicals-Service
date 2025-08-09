<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePieceRequest extends FormRequest
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
            'pieces_id' => 'required|exists:pieces,pieces_id',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'pieces_id.required' => 'The piece ID is required.',
            'pieces_id.exists' => 'The selected piece does not exist.',
            'name.required' => 'The piece name is required.',
            'name.max' => 'The piece name may not be greater than 255 characters.',
            'price.required' => 'The piece price is required.',
            'price.numeric' => 'The piece price must be a number.',
            'price.min' => 'The piece price must be greater than or equal to 0.',
        ];
    }
}
