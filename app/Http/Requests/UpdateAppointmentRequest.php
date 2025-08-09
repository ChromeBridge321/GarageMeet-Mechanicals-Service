<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAppointmentRequest extends FormRequest
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
            'appointment_date' => 'required|date|after:now',
            'status' => 'sometimes|in:pending,confirmed,cancelled,completed',
            'notes' => 'sometimes|string|max:1000',
        ];
    }

    /**
     * Get custom error messages for validation rules.
     */
    public function messages(): array
    {
        return [
            'appointment_date.required' => 'La fecha de la cita es requerida.',
            'appointment_date.date' => 'La fecha debe tener un formato válido.',
            'appointment_date.after' => 'La fecha de la cita debe ser en el futuro.',
            'status.in' => 'El estado debe ser: pending, confirmed, cancelled o completed.',
            'notes.max' => 'Las notas no pueden exceder 1000 caracteres.',
        ];
    }
}
