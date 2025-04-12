<?php

namespace App\Repositories\Contracts;

use App\Models\Reservation;

class ReservationRepositoryData
{

    public function all()
    {
        return Reservation::all();
    }

    public function findBySlug(string $slug)    
    {
        return Reservation::where('slug', $slug)->first();
    }

    public function create(array $data)
    {
        return Reservation::create($data);
    }

    public function update($reservation, array $data){
        $reservation->update($data);
        return $reservation;
    }

    public function delete(string $slug)
    {
        $reservation = Reservation::where('slug', $slug)->first();
        if (!$reservation) {
            return $this->error('', 'Reservation not found', 404);
        }
        $reservation->delete();
        return $this->success('', 'Reservation deleted successfully', 200);
    }

    public function findByRiad(string $riadSlug)
    {
        $reservations = Reservation::where('riad_slug', $riadSlug)->get();
        if ($reservations->isEmpty()) {
            return $this->error('', 'Reservations not found', 404);
        }
        return $reservations;
    }
    public function findByChambre(string $chambreSlug)
    {
        $reservations = Reservation::where('chambre_slug', $chambreSlug)->get();
        if ($reservations->isEmpty()) {
            return $this->error('', 'Reservations not found', 404);
        }
        return $reservations;
    }
    public function findByClient(string $clientSlug)
    {
        $reservations = Reservation::where('client_slug', $clientSlug)->get();
        if ($reservations->isEmpty()) {
            return $this->error('', 'Reservations not found', 404);
        }
        return $reservations;
    }
    
}
