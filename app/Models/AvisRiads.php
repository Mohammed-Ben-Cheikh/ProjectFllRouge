<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AvisRiads extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'riad_id',
        'commentaire',
        'note'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function riad()
    {
        return $this->belongsTo(Riad::class);
    }
}
