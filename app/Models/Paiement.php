<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{
    use HasFactory;

    protected $fillable = [
        'montant',
        'invoice',
        'tourist_name',
        'tourist_email',
        'reference_path',
        'reservation_id',
        'status',
        'service_reservation_id',
        'riad_id'
    ];

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

    public function serviceReservation()
    {
        return $this->belongsTo(ServiceReservation::class);
    }

    public function riad($value)
    {
        return $this->belongsTo(Riad::class);
    }
}
