<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'prix',
        'duree_minutes',
        'type',
        'categorie',
        'unite_mesure',
        'capacite_max',
        'reservation_requise',
        'heure_ouverture',
        'heure_fermeture',
        'jours_disponibles',
        'statut',
        'riad_id',
    ];

    protected $casts = [
        'jours_disponibles' => 'array', // Auto-converts JSON <-> PHP array
        'capacity' => 'array',    // If you're using JSON for capacity too
    ];

    public function entreprise()
    {
        return $this->belongsTo(Entreprise::class);
    }

    public function images()
    {
        return $this->hasMany(ServiceImages::class);
    }

    public function avis()
    {
        return $this->hasMany(AvisServices::class);
    }
}
