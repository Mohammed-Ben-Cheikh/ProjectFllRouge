<?php

namespace App\Repositories\data;

use App\Models\Reservation;
use App\Traits\HttpResponses;
use App\Repositories\Contracts\ReservationRepository;

class ReservationRepositoryData implements ReservationRepository
{
    use HttpResponses;

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

    public function update($reservation, array $data)
    {
        $reservation->update($data);
        return $reservation;
    }

    public function delete(string $slug)
    {
        $reservation = $this->findBySlug($slug);
        if (!$reservation) {
            return $this->error('', 'Reservation not found', 404);
        }
        $reservation->delete();
        return $this->success('', 'Reservation deleted successfully', 200);
    }

    public function findByUser(string $userSlug)
    {
        $reservations = Reservation::whereHas('user', function($query) use ($userSlug) {
            $query->where('slug', $userSlug);
        })->get();

        if ($reservations->isEmpty()) {
            return $this->error('', 'No reservations found for this user', 404);
        }
        return $reservations;
    }

    public function findByChambre(string $chambreSlug)
    {
        $reservations = Reservation::whereHas('chambre', function($query) use ($chambreSlug) {
            $query->where('slug', $chambreSlug);
        })->get();

        if ($reservations->isEmpty()) {
            return $this->error('', 'No reservations found for this chambre', 404);
        }
        return $reservations;
    }

    public function findByStatus(string $status)
    {
        $reservations = Reservation::where('statut', $status)->get();
        if ($reservations->isEmpty()) {
            return $this->error('', 'No reservations found with this status', 404);
        }
        return $reservations;
    }
}
