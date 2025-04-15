<?php

namespace App\Http\Controllers;

use App\Models\Ville;
use App\Http\Requests\StoreVilleRequest;
use App\Http\Requests\UpdateVilleRequest;
use App\Repositories\Contracts\VilleRepository;

class VilleController extends Controller
{
    protected $villeRepository;
    public function __construct(VilleRepository $villeRepository)
    {
        $this->villeRepository = $villeRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->villeRepository->all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVilleRequest $request)
    {
        return $this->villeRepository->create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
        return $this->villeRepository->findBySlug($slug);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreVilleRequest $request, $slug)
    {
        return $this->villeRepository->update($slug, $request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ville $ville)
    {
        return $this->villeRepository->delete($ville);
    }
}
