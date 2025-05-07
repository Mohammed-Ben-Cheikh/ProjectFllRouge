<?php

namespace App\Repositories\data;

use App\Models\Chambre;
use App\Models\Paiement;
use App\Models\Reservation;
use App\Models\Service;
use App\Models\ServiceReservation;
use App\Traits\HttpResponses;
use App\Repositories\Contracts\PaiementRepository;

class PaiementRepositoryData implements PaiementRepository
{
    use HttpResponses;

    public function all()
    {
        $riad = ChambreRepositoryData::employe('riad');

        $paiements = Paiement::with(['reservation', 'serviceReservation'])
            ->where(function($query) use ($riad) {
                $query->whereHas('reservation.chambre', function($q) use ($riad) {
                    $q->where('riad_id', $riad->id);
                })
                ->orWhereHas('serviceReservation.service', function($q) use ($riad) {
                    $q->where('riad_id', $riad->id);
                });
            })
            ->get();

        if ($paiements->isEmpty()) {
            return $this->error('', 'No paiements found', 404);
        }

        return $this->success(['paiements' => $paiements], 'Paiements retrieved successfully', 200);
    }

    public function findBySlug(string $slug)
    {
        return Paiement::where('slug', $slug)->first();
    }

    public function create(array $data)
    {

        $reservation = Reservation::where('invoice', $data['invoice'])->first();
        if ($reservation) {
            $data['reservation_id'] = $reservation->id;
        } else {
            $reservation = ServiceReservation::where('invoice', $data['invoice'])->first();
            if (!$reservation) {
                return $this->error(null, 'Reservation not found', 404);
            }
            $data['service_reservation_id'] = $reservation->id;
        }
        $data['invoice'] = $reservation->invoice;
        $data['reference_path'] = $data['reference_File']->store('paiements', 'public');

        $paiement = Paiement::create($data);
        if ($paiement) {
            if (isset($data['reservation_id'])) {
                Reservation::where('id', $data['reservation_id'])->update(['has_payment_proof' => 1]);
            } else {
                ServiceReservation::where('id', $data['service_reservation_id'])->update(['has_payment_proof' => 1]);
            }
        }
        return $this->success(['paiement' => $paiement], 'Paiement created successfully', 201);
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

    public function updateStatus($invoice, $status)
    {
        $paiement = Paiement::where('invoice', $invoice)->first();
        if (!$paiement) {
            return $this->error('', 'Paiement not found', 404);
        }
        if ($paiement->update(['status' => $status])){
            Reservation::where('invoice',$invoice)->update(['statut' => 'confirmee']);
            return $this->success(['paiement' => $paiement], 'Paiement status updated successfully', 200);
        }

        return $this->error(null,'error');

    }
}
