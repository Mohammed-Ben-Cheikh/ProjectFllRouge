<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{
    use HasFactory;

    protected $fillable = [
        'montant',
        'statut',
        'methode_paiement',
        'reservation_id',
        'reference_transaction'
    ];

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }
}
