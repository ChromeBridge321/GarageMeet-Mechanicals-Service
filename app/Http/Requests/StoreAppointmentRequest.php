<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAppointmentRequest extends FormRequest
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
            'mechanical_workshops_id' => 'required|exists:mechanical_workshops,id',
            'client_name' => 'required|string|max:255',
            'client_email' => 'required|email|max:255',
            'client_phone' => 'required|string|max:20',
            'description' => 'required|string|max:1000',
            'created_by' => 'sometimes|in:app,dashboard'
        ];
    }

    /**
     * Get custom error messages for validation rules.
     */
    public function messages(): array
    {
        return [
            'mechanical_workshops_id.required' => 'El taller es requerido.',
            'mechanical_workshops_id.exists' => 'El taller seleccionado no existe.',
            'client_name.required' => 'El nombre del cliente es requerido.',
            'client_email.required' => 'El email del cliente es requerido.',
            'client_email.email' => 'El email debe tener un formato válido.',
            'client_phone.required' => 'El teléfono del cliente es requerido.',
            'description.required' => 'La descripción del problema es requerida.',
            'description.max' => 'La descripción no puede exceder 1000 caracteres.',
        ];
    }
}
