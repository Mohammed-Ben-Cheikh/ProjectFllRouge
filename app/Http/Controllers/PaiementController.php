<?php

namespace App\Http\Controllers;

use App\Models\Paiement;
use App\Http\Requests\StorePaiementRequest;
use App\Http\Requests\UpdatePaiementRequest;
use App\Repositories\Contracts\PaiementRepository;

class PaiementController extends Controller
{
    protected $paiementRepository;

    public function __construct(PaiementRepository $paiementRepository)
    {
        $this->paiementRepository = $paiementRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->paiementRepository->all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePaiementRequest $request)
    {
        return $this->paiementRepository->create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
        return $this->paiementRepository->findBySlug($slug);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($slug, StorePaiementRequest $request)
    {
        return $this->paiementRepository->update($slug, $request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($slug)
    {
        return $this->paiementRepository->delete($slug);
    }

    /**
     * Find payments by reservation
     */
    public function findByReservation($reservationSlug)
    {
        return $this->paiementRepository->findByReservation($reservationSlug);
    }

    /**
     * Find payments by user
     */
    public function findByUser($userSlug)
    {
        return $this->paiementRepository->findByUser($userSlug);
    }
}
