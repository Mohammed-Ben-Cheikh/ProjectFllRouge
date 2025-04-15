<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAvisRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'user_id' => 'required|exists:users,id',
            'commentaire' => 'required|string|min:10',
            'note' => 'required|integer|between:1,5'
        ];

        // Add conditional validation based on the type of review
        switch($this->input('type')) {
            case 'riad':
                $rules['riad_id'] = 'required|exists:riads,id';
                break;
            case 'chambre':
                $rules['chambre_id'] = 'required|exists:chambres,id';
                break;
            case 'service':
                $rules['service_id'] = 'required|exists:services,id';
                break;
            default:
                $rules['type'] = 'required|in:riad,chambre,service';
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'type.required' => 'Le type d\'avis est requis (riad, chambre ou service)',
            'type.in' => 'Le type d\'avis doit être riad, chambre ou service',
            'commentaire.min' => 'Le commentaire doit faire au moins 10 caractères',
            'note.between' => 'La note doit être comprise entre 1 et 5'
        ];
    }
}
