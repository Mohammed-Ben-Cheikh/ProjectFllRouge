<?php

namespace App\Models;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Service extends Model
{
    use HasFactory, HasSlug;

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

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name') // Génère le slug à partir du nom
            ->saveSlugsTo('slug')
            ->slugsShouldBeNoLongerThan(50); // Limite la longueur du slug à 50 caractères
    }
}
