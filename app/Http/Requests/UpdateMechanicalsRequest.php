<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMechanicalsRequest extends FormRequest
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
            'id' => 'required|int|exists:mechanical_workshops,id',
            'users_id' => 'required|int',
            'cities_id' => 'required|int',
            'name' => 'required|string|max:60',
            'cellphone_number' => 'required|string|max:10',
            'email' => 'required|email|max:120',
            'address' => 'required|string|max:255',
            'google_maps_link' => 'required|string|max:255',
        ];
    }
}
