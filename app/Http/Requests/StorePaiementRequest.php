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
            'montant' => 'required|numeric|min:0',
            'statut' => 'required|string|in:pending,completed,failed,refunded',
            'methode_paiement' => 'required|string|in:card,bank_transfer,cash',
            'reservation_id' => 'required|exists:reservations,id',
            'reference_transaction' => 'required|string|unique:paiements,reference_transaction'
        ];
    }
}
