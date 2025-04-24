<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employe extends Model
{
    use HasFactory;

    protected $fillable = [
        'entreprise_id',
        'riad_id',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function riad()
    {
        return $this->belongsTo(Riad::class);
    }

    public function entreprise()
    {
        return $this->belongsTo(Entreprise::class);
    }
}
