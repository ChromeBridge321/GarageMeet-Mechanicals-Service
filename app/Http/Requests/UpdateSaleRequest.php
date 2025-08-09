<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSaleRequest extends FormRequest
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
            'services_sales_id' => 'required|exists:services_sales,services_sales_id',
            'payment_types_id' => 'sometimes|exists:payment_types,payment_types_id',
            'employees_id' => 'sometimes|exists:employees,employees_id',
            'vehicles_id' => 'sometimes|exists:vehicles,vehicles_id',
            'mechanical_workshops_id' => 'sometimes|exists:mechanical_workshops,id',
            'date' => 'sometimes|date',
            'price' => 'sometimes|numeric|min:0',
            'services' => 'sometimes|array',
            'pieces' => 'sometimes|array',
        ];
    }
}
