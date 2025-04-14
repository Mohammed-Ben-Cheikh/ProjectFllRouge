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
            'nom' => ['required', 'string', 'max:255', 'unique:riads,nom'],
            'adresse' => ['required', 'string', 'max:255'],
            'telephone' => ['required', 'string', 'max:20'],
            'fax' => ['required', 'string', 'max:20'],
            'email' => ['required', 'email', 'max:255'],
            'description' => ['required', 'string'],
            'total_chambres' => ['required', 'integer', 'min:0'],
            'ville_id' => ['required', 'exists:villes,id'], // Assurez-vous que la ville existe
            'entreprise_id' => ['required', 'exists:entreprises,id'], // Assurez-vous que l'entreprise existe
        ];
    }
}
