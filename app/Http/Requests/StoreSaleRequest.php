<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSaleRequest extends FormRequest
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
            'payment_types_id' => 'required|exists:payment_types,payment_types_id',
            'employees_id' => 'required|exists:employees,employees_id',
            'vehicles_id' => 'required|exists:vehicles,vehicles_id',
            'mechanical_workshops_id' => 'required|exists:mechanical_workshops,id',
            'date' => 'required|date',
            'price' => 'required|numeric|min:0',
            'services' => 'required|array',
            'pieces' => 'required|array',
        ];
    }
}
