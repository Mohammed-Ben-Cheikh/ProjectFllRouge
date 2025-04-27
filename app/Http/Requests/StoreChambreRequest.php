<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreChambreRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'nombre' => 'required|string|max:255',
            'type' => 'required|string|in:standard,suite,deluxe',
            'prix' => 'required|numeric|min:0',
            'surface' => 'required|numeric|min:1',
            'capacity.nombre_adultes' => 'required|integer|min:1|max:10',
            'capacity.nombre_enfants' => 'required|integer|min:0|max:10',
            'nombre_lits' => 'required|integer|min:1|max:10',
            'equipements' => 'nullable|array',
            'equipements.*' => 'string',
            'statut' => 'required|string|in:available,unavailable,booked',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'required|string',
        ];
    }
}
