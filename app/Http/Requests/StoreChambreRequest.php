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
            'nom' => 'required|string|max:255',
            'description' => 'required|string',
            'prix' => 'required|numeric|min:0',
            'capacite' => 'required|integer|min:1',
            'disponibilite' => 'boolean',
            'riad_id' => 'required|exists:riads,id',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ];
    }
}
