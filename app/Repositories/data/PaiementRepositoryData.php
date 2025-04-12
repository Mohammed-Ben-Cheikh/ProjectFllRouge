<?php

namespace App\Repositories\data;

use App\Models\Paiement;
use App\Traits\HttpResponses;
use App\Repositories\Contracts\PaiementRepository;

class PaiementRepositoryData implements PaiementRepository
{
    use HttpResponses;

    public function all()
    {
        return Paiement::all();
    }

    public function findBySlug(string $slug)
    {
        return Paiement::where('slug', $slug)->first();
    }

    public function create(array $data)
    {
        return Paiement::create($data);
    }

    public function update($paiement, array $data)
    {
        $paiement->update($data);
        return $paiement;
    }

    public function delete(string $slug)
    {
        $paiement = $this->findBySlug($slug);
        if (!$paiement) {
            return $this->error('', 'Paiement not found', 404);
        }
        $paiement->delete();
        return $this->success('', 'Paiement deleted successfully', 200);
    }

    public function findByReservation(string $reservationSlug)
    {
        return Paiement::whereHas('reservation', function($query) use ($reservationSlug) {
            $query->where('slug', $reservationSlug);
        })->first();
    }

    public function findByUser(string $userSlug)
    {
        $paiements = Paiement::whereHas('reservation.user', function($query) use ($userSlug) {
            $query->where('slug', $userSlug);
        })->get();

        if ($paiements->isEmpty()) {
            return $this->error('', 'No paiements found for this user', 404);
        }
        return $paiements;
    }
}
