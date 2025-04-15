<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VilleImages extends Model
{
    use HasFactory;

    protected $fillable = [
        'ville_id',
        'image_url',
        'is_primary'
    ];

    public function ville()
    {
        return $this->belongsTo(Ville::class);
    }
}
