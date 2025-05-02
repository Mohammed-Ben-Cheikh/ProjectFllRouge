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
            'chambre_id' => 'required|exists:chambres,id',
            'nombre_personnes' => 'required|integer|min:1',
            'note_client' => 'nullable|string',
            'nom_complet' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telephone' => 'required|string|max:20',
            'mode_paiement' => 'required|string|in:espece,carte,virement',
            'montant_total' => 'required|numeric|min:0'
        ];
    }
}
