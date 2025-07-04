<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice',
        'rib',
        'mode_paiement',
        'note_client',
        'nom_complet',
        'email',
        'telephone',
        'date_debut',
        'date_fin',
        'statut',
        'user_id',
        'chambre_id',
        'nombre_personnes',
        'montant_total',
    ];

    protected $casts = [
        'date_debut' => 'datetime',
        'date_fin' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function chambre()
    {
        return $this->belongsTo(Chambre::class);
    }

    public function paiement()
    {
        return $this->hasOne(Paiement::class);
    }
}
