<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePaiementRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'invoice' => 'required|string|unique:paiements,invoice',
            'tourist_name' => 'nullable|string',
            'tourist_email' => 'nullable|email',
            'montant' => 'nullable|numeric|min:0',
            'reference_File' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ];
    }
}
