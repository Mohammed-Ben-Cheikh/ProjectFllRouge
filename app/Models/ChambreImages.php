<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChambreImages extends Model
{
    use HasFactory;

    protected $fillable = [
        'chambre_id',
        'image_url',
        'is_primary'
    ];

    public function chambre()
    {
        return $this->belongsTo(Chambre::class);
    }
}
