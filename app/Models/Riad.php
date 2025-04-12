<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Riad extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'description',
        'adresse',
        'ville_id',
        'user_id',
        'telephone',
        'email'
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
}
