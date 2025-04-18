<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\SlugOptions;
use Spatie\Sluggable\HasSlug;

class Riad extends Model
{
    use HasFactory, HasSlug;

    protected $fillable = [
        'nom',
        'description',
        'adresse',
        'telephone',
        'fax',
        'email',
        'site_web',
        'nombre_chambres',
        'entreprise_id',
        'ville_id',
    ];

    public function ville()
    {
        return $this->belongsTo(Ville::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function chambres()
    {
        return $this->hasMany(Chambre::class);
    }

    public function images()
    {
        return $this->hasMany(RiadImages::class);
    }

    public function avis()
    {
        return $this->hasMany(AvisRiads::class);
    }

    public function favoris()
    {
        return $this->hasMany(Favoris::class);
    }

    public function employes()
    {
        return $this->hasMany(Employe::class);
    }

    public function entreprise()
    {
        return $this->belongsTo(Entreprise::class);
    }

    public function services()
    {
        return $this->hasMany(Service::class);
    }
    
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('nom') // Génère le slug à partir du nom
            ->saveSlugsTo('slug')
            ->slugsShouldBeNoLongerThan(50); // Limite la longueur du slug à 50 caractères
    }
}
