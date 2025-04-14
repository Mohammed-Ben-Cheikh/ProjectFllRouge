<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Ville extends Model
{
    use HasFactory, HasSlug;

    protected $fillable = [
        'nom',
        'image_url',
        'description'
    ];

    public function riads()
    {
        return $this->hasMany(Riad::class);
    }
    public function avis()
    {
        return $this->hasMany(AvisVilles::class);
    }

    public function images()
    {
        return $this->hasMany(VilleImages::class);
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('nom')
            ->saveSlugsTo('slug');
    }
}
