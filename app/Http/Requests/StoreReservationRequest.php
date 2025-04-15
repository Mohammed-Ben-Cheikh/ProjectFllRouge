<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReservationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'date_debut' => 'required|date|after:today',
            'date_fin' => 'required|date|after:date_debut',
            'statut' => 'required|string|in:pending,confirmed,cancelled,completed',
            'user_id' => 'required|exists:users,id',
            'chambre_id' => 'required|exists:chambres,id',
            'nombre_personnes' => 'required|integer|min:1',
            'prix_total' => 'required|numeric|min:0'
        ];
    }
}
