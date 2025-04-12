<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chambre extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'description',
        'prix',
        'capacite',
        'disponibilite',
        'riad_id'
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
}
