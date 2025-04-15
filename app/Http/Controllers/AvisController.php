<?php

namespace App\Http\Controllers;

use App\Models\AvisChambers;
use App\Models\AvisRiads;
use App\Models\AvisServices;
use App\Http\Requests\StoreavisRequest;
use App\Repositories\Contracts\AvisRepository;

class AvisController extends Controller
{
    protected $avisRepository;

    public function __construct(AvisRepository $avisRepository)
    {
        $this->avisRepository = $avisRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->avisRepository->all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreavisRequest $request)
    {
        return $this->avisRepository->create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
        return $this->avisRepository->findBySlug($slug);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($slug, StoreavisRequest $request)
    {
        return $this->avisRepository->update($slug, $request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($slug)
    {
        return $this->avisRepository->delete($slug);
    }

    /**
     * Find reviews by riad
     */
    public function findByRiad($riadSlug)
    {
        return $this->avisRepository->findByRiad($riadSlug);
    }

    /**
     * Find reviews by chambre
     */
    public function findByChambre($chambreSlug)
    {
        return $this->avisRepository->findByChambre($chambreSlug);
    }

    /**
     * Find reviews by service
     */
    public function findByService($serviceSlug)
    {
        return $this->avisRepository->findByService($serviceSlug);
    }
}
