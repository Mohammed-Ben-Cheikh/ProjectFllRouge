<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceReservation extends Model
{
    use HasFactory;
    protected $table = 'service_reservations';

    protected $fillable = [
        'service_id',
        'invoice',
        'rib',
        'date',
        'nombre_personnes',
        'statut',
        'montant_total',
        'mode_paiement',
        'note_client',
        'nom_complet',
        'email',
        'telephone',
        'user_id'
    ];

    protected $casts = [
        'date' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function paiement()
    {
        return $this->hasOne(Paiement::class);
    }
}
