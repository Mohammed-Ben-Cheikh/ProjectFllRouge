<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdateServiceRequest;
use App\Repositories\Contracts\ServiceRepository;

class ServiceController extends Controller
{
    protected $serviceRepository;

    public function __construct(ServiceRepository $serviceRepository)
    {
        $this->serviceRepository = $serviceRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->serviceRepository->all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreServiceRequest $request)
    {
        return $this->serviceRepository->create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
        return $this->serviceRepository->findBySlug($slug);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($slug, StoreServiceRequest $request)
    {
        return $this->serviceRepository->update($slug, $request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($slug)
    {
        return $this->serviceRepository->delete($slug);
    }

    /**
     * Find services by entreprise
     */
    public function findByEntreprise($entrepriseSlug)
    {
        return $this->serviceRepository->findByEntreprise($entrepriseSlug);
    }
}
