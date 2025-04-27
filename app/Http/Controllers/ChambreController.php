<?php

namespace App\Http\Controllers;

use App\Models\Chambre;
use Illuminate\Http\Request;
use App\Http\Requests\StoreChambreRequest;
use App\Http\Requests\UpdateChambreRequest;
use App\Repositories\Contracts\ChambreRepository;

class ChambreController extends Controller
{
    protected $chambreRepository;

    public function __construct(ChambreRepository $chambreRepository)
    {
        $this->chambreRepository = $chambreRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->chambreRepository->all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreChambreRequest $request)
    {
        return $this->chambreRepository->create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
        return $this->chambreRepository->findBySlug($slug);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($slug, StoreChambreRequest $request)
    {
        return $this->chambreRepository->update($slug, $request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($slug)
    {
        return $this->chambreRepository->delete($slug);
    }

    /**
     * Find rooms by riad
     */
    public function findByRiad($riadSlug)
    {
        return $this->chambreRepository->findByRiad($riadSlug);
    }

    public function findByEmployee()
    {
        return $this->chambreRepository->findByEmployee();
    }

    public function updateStatus($slug, Request $request)
    {
        return $this->chambreRepository->updateStatus($slug, $request->validated());
    }
}
