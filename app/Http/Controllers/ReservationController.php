<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Http\Requests\StoreReservationRequest;
use App\Repositories\Contracts\ReservationRepository;
use App\Http\Requests\StoreServicesReservationRequest;

class ReservationController extends Controller
{
    protected $reservationRepository;

    public function __construct(ReservationRepository $reservationRepository)
    {
        $this->reservationRepository = $reservationRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->reservationRepository->all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReservationRequest $request)
    {
        return $this->reservationRepository->create($request->validated());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($slug, StoreReservationRequest $request)
    {
        return $this->reservationRepository->update($slug, $request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($slug)
    {
        return $this->reservationRepository->delete($slug);
    }

    /**
     * Find reservations by user
     */
    public function findByUser()
    {
        return $this->reservationRepository->findByUser();
    }

    /**
     * updeate reservation status
     */
    public function updateStatus($invoice, $type, Request $request, )
    {
        return $this->reservationRepository->updateStatus($invoice, $type, $request->validate(['status' => 'required|in:en_attente,confirmee,annulee,terminee'])['status']);
    }

    /**
     * Find reservations by chambre
     */
    public function findByChambre($chambreSlug)
    {
        return $this->reservationRepository->findByChambre($chambreSlug);
    }

    /**
     * Find reservations by status
     */
    public function findByRiadForChambres()
    {
        return $this->reservationRepository->findByRiadForChambres();
    }

    public function findByRiadForServices()
    {
        return $this->reservationRepository->findByRiadForServices();
    }

    /**
     * Create a service reservation
     */
    public function storeServiceReservation(StoreServicesReservationRequest $request)
    {
        return $this->reservationRepository->createServiceReservation($request->validated());
    }

    /**
     * Update a service reservation
     */
    public function updateServiceReservation($slug, StoreServicesReservationRequest $request)
    {
        return $this->reservationRepository->updateServiceReservation($slug, $request->validated());
    }

    /**
     * Delete a service reservation
     */
    public function destroyServiceReservation($slug)
    {
        return $this->reservationRepository->deleteServiceReservation($slug);
    }
    /**
     * Find service reservations by user
     */

    public function findServiceReservationByUser()
    {
        return $this->reservationRepository->findServiceReservationByUser();
    }
    /**
     * Find reservations by service
     */

    public function findByService($serviceSlug)
    {
        return $this->reservationRepository->findByService($serviceSlug);
    }

    /**
     * Update service reservation status
     */
    public function updateServiceReservationStatus($invoice, Request $request)
    {
        return $this->reservationRepository->updateServiceReservationStatus($invoice, $request->validate(['status' => 'required|in:en_attente,confirmee,annulee,terminee'])['status']);
    }
}
