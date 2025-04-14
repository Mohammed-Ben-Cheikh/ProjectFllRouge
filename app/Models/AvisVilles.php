<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AvisVilles extends Model
{
    protected $fillable = [
        'note',
        'commentaire',
        'ville_id',
        'user_id'
    ];

    public function ville()
    {
        return $this->belongsTo(Ville::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
