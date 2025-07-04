<?php

namespace App\Repositories\data;

use App\Models\Chambre;
use App\Models\Reservation;
use App\Models\Riad;
use App\Models\Service;
use App\Traits\HttpResponses;
use App\Models\ServiceReservation;
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
        $data['user_id'] = auth()->user()->id;
        $data['invoice'] = 'INV-' . strtoupper(uniqid());
        $reservation = Reservation::create($data);
        return $this->success(['reservation' => $reservation], 'Reservation created successfully', 201);
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

    public function findByUser()
    {
        $reservations = Reservation::where('user_id', auth()->user()->id)
            ->with([
                'chambre' => function ($query) {
                    $query->with('images');
                }
            ])
            ->get();

        if ($reservations->isEmpty()) {
            return $this->error('', 'No reservations found for this user', 404);
        }
        return $this->success(['reservations' => $reservations], 'Reservations found successfully', 200);
    }

    public function updateStatus(string $invoice, string $type, string $status)
    {
        $model = $type === 'chambre' ? Reservation::class :
            ($type === 'service' ? ServiceReservation::class : null);

        if (!$model) {
            return $this->error('', 'Invalid reservation type', 400);
        }

        $reservation = $model::where('invoice', $invoice)->first();

        if (!$reservation) {
            return $this->error($invoice, 'Reservation not found', 404);
        }

        $reservation->update(['statut' => $status]);

        $message = $type === 'chambre' ? 'Reservation' : 'Service reservation';
        return $this->success(['reservation' => $reservation], "$message status updated successfully", 200);
    }

    public function findByChambre(string $chambreSlug)
    {
        $reservations = Reservation::whereHas('chambre', function ($query) use ($chambreSlug) {
            $query->where('slug', $chambreSlug);
        })->get();

        $reservations = $reservations->map(function ($reservation) {
            return [
                'date_debut' => $reservation->date_debut,
                'date_fin' => $reservation->date_fin
            ];
        });

        if ($reservations->isEmpty()) {
            return $this->error('', 'No reservations found for this chambre', 404);
        }
        return $this->success(['reservations' => $reservations], 'Reservations found successfully', 200);
    }

    public function findByRiadForChambres()
    {
        $riads = ChambreRepositoryData::employe('riad');
        $chambres = Chambre::where('riad_id', $riads->id)->get();
        $reservations = Reservation::whereHas('chambre', function ($query) use ($chambres) {
            $query->whereIn('id', $chambres->pluck('id'));
        })->with([
                    'chambre' => function ($query) {
                        $query->with('images');
                    }
                ])->get();

        // return $this->error(['reservations' => $reservations], 'No riads found for this employee', 404);
        // $reservations =

        if ($reservations->isEmpty()) {
            return $this->error('', 'No reservations found for this riad', 404);
        }
        return $this->success(['reservations' => $reservations], 'Reservations found successfully', 200);
    }

    public function findByRiadForServices()
    {
        $riads = ChambreRepositoryData::employe('riad');
        $services = Service::where('riad_id', $riads->id)->get();
        $reservations = ServiceReservation::whereHas('service', function ($query) use ($services) {
            $query->whereIn('id', $services->pluck('id'));
        })->with([
                    'service' => function ($query) {
                        $query->with('images');
                    }
                ])->get();

        if ($reservations->isEmpty()) {
            return $this->error('', 'No reservations found for this riad', 404);
        }
        return $this->success(['reservations' => $reservations], 'Reservations found successfully', 200);
    }

    public function createServiceReservation(array $data)
    {
        $data['user_id'] = auth()->user()->id;
        $data['invoice'] = 'INV-' . strtoupper(uniqid());

        $reservation = ServiceReservation::create($data);

        $service = Service::where('id', $data['service_id'])->first();
        $riad = Riad::where('id', $service->riad_id)->first();

        if ($reservation) {
            Riad::where('id', $riad->id)->increment('reservations');
        }
        return $this->success(['reservation' => $reservation], 'Reservation created successfully', 201);
    }

    public function updateServiceReservation($reservation, array $data)
    {
        $reservation->update($data);
        return $reservation;
    }
    public function deleteServiceReservation(string $slug)
    {
        $reservation = $this->findBySlug($slug);
        if (!$reservation) {
            return $this->error('', 'Reservation not found', 404);
        }
        $reservation->delete();
        return $this->success('', 'Reservation deleted successfully', 200);
    }

    public function findServiceReservationByUser()
    {
        $reservations = ServiceReservation::where('user_id', auth()->user()->id)
            ->with([
                'service' => function ($query) {
                    $query->with('images');
                }
            ])
            ->get();

        if ($reservations->isEmpty()) {
            return $this->error('', 'No reservations found for this user', 404);
        }
        return $this->success(['reservations' => $reservations], 'Reservations found successfully', 200);
    }

    public function updateServiceReservationStatus(string $invoice, string $status)
    {
        $reservation = ServiceReservation::where('invoice', $invoice)->first();
        if (!$reservation) {
            return $this->error($invoice, 'Reservation not found', 404);
        }
        $reservation->update(['statut' => $status]);
        return $this->success(['reservation' => $reservation], 'Reservation status updated successfully', 200);
    }

    public function findByService(string $serviceSlug)
    {
        $reservations = ServiceReservation::whereHas('service', function ($query) use ($serviceSlug) {
            $query->where('slug', $serviceSlug);
        })->get();

        $reservations = $reservations->map(function ($reservation) {
            return [
                'date' => $reservation->date,
            ];
        });

        if ($reservations->isEmpty()) {
            return $this->error('', 'No reservations found for this service', 404);
        }
        return $this->success(['reservations' => $reservations], 'Reservations found successfully', 200);
    }
}
