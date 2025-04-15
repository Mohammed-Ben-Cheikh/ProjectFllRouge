<?php

namespace App\Http\Controllers;

use App\Models\Entreprise;
use App\Http\Requests\StoreEntrepriseRequest;
use App\Http\Requests\UpdateEntrepriseRequest;
use App\Repositories\Contracts\EntrepriseRepository;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class EntrepriseController extends Controller
{
    protected $entrepriseRepository;

    public function __construct(EntrepriseRepository $entrepriseRepository)
    {
        $this->entrepriseRepository = $entrepriseRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->entrepriseRepository->all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEntrepriseRequest $request)
    {
        return $this->entrepriseRepository->create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
        return $this->entrepriseRepository->findBySlug($slug);
    }


    /**
     * Display the specified resource.
     */
    public function findByUser()
    {
        return $this->entrepriseRepository->findByUser();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($slug, StoreEntrepriseRequest $request)
    {
        return $this->entrepriseRepository->update($slug, $request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($slug)
    {
        return $this->entrepriseRepository->delete($slug);
    }

    public function addImage($slug, Request $request)
    {
        return $this->entrepriseRepository->addImage($slug, $request);
    }
}
