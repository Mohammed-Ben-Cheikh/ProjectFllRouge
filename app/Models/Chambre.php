<?php

namespace App\Models;


use Spatie\Sluggable\HasSlug;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Chambre extends Model
{
    use HasFactory, HasSlug;

    protected $fillable = [
        'name',
        'city',
        'nombre',
        'type',
        'description',
        'equipements',
        'prix',
        'nombre_lits',
        'capacity',
        'surface',
        'statut',
        'riad_id'
    ];

    protected $casts = [
        'equipements' => 'array', // Auto-converts JSON <-> PHP array
        'capacity' => 'array',    // If you're using JSON for capacity too
    ];

    public function riad()
    {
        return $this->belongsTo(Riad::class);
    }

    public function images()
    {
        return $this->hasMany(ChambreImages::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function avis()
    {
        return $this->hasMany(AvisChambers::class);
    }

    public function getSlugOptions(): \Spatie\Sluggable\SlugOptions
    {
        return \Spatie\Sluggable\SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }
}
