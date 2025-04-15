<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEntrepriseRequest extends FormRequest
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
            'nom' => ['required', 'string', 'max:255', 'unique:entreprises,nom'],
            'type' => ['required', 'string'],
            'adresse' => ['required', 'string'],
            'telephone' => ['required', 'numeric'],
            'fax' => ['required', 'numeric'],
            'email' => ['required', 'email'],
            'site_web' => ['required', 'url'],
            'description' => ['required', 'string']
        ];
    }
}
