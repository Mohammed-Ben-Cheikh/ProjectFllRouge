<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmployeRequest extends FormRequest
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
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:employes,email',
            'telephone' => 'required|string|max:20',
            'adresse' => 'required|string|max:255',
            'poste' => 'required|string|max:100',
            'salaire' => 'required|numeric|min:0',
            'date_embauche' => 'required|date',
            'riad_id' => 'required|exists:riads,id',
            'user_id' => 'required|exists:users,id'
        ];
    }
}
