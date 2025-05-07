<?php

namespace App\Http\Controllers;

use App\Models\Paiement;
use App\Http\Requests\StorePaiementRequest;
use App\Http\Requests\UpdatePaiementRequest;
use App\Repositories\Contracts\PaiementRepository;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class PaiementController extends Controller
{
    use HttpResponses;
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

    /**
     * update the status of a payment
     */
    public function updateStatus($invoice, Request $request)
    {
        return $this->paiementRepository->updateStatus($invoice, $request->validate(['status' => 'required|in:approved,pending,rejected'])['status']);
    }
}
