<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRiadRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255', 'unique:riads,name'],
            'rib' => ['required', 'string', 'max:255'],
            'status' => ['sometimes', 'string', 'in:pending,approved,rejected'],
            'address' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'string', 'email', 'max:255'],
            'telephone' => ['nullable', 'string', 'max:255'],
            'fax' => ['nullable', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'rooms' => ['required', 'integer', 'min:0'],
            'owner' => ['required', 'string', 'max:255'],
            'facilities' => ['nullable', 'json'],
            'features' => ['nullable', 'json'],
            'ville_id' => ['required', 'exists:villes,id'], // Assurez-vous que la ville existe
            'entreprise_id' => ['required', 'exists:entreprises,id'], // Assurez-vous que l'entreprise existe
            'images' => ['required', 'array', 'max:5'],
            'images.*' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ];
    }
}
