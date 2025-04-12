<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ville extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'description'
    ];

    public function riads()
    {
        return $this->hasMany(Riad::class);
    }

    public function images()
    {
        return $this->hasMany(VilleImages::class);
    }
}
