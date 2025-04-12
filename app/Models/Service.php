<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'description',
        'prix',
        'entreprise_id',
        'disponibilite'
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
