<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Http\Requests\StoreReservationRequest;
use App\Http\Requests\UpdateReservationRequest;
use App\Repositories\Contracts\ReservationRepository;

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
     * Display the specified resource.
     */
    public function show($slug)
    {
        return $this->reservationRepository->findBySlug($slug);
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
    public function findByUser($userSlug)
    {
        return $this->reservationRepository->findByUser($userSlug);
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
    public function findByStatus($status)
    {
        return $this->reservationRepository->findByStatus($status);
    }
}
