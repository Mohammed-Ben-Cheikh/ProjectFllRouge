<?php

namespace App\Http\Controllers;

use App\Models\Riad;
use Illuminate\Http\Request;
use App\Http\Requests\StoreRiadRequest;
use App\Http\Requests\UpdateRiadRequest;
use App\Repositories\Contracts\RiadRepository;

class RiadController extends Controller
{
    protected $riadRepository;

    public function __construct(RiadRepository $riadRepository)
    {
        $this->riadRepository = $riadRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->riadRepository->all();
    }

    public function findByUser()
    {
        return $this->riadRepository->findUser();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRiadRequest $request)
    {
        return $this->riadRepository->create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
        return $this->riadRepository->findBySlug($slug);
    }

    /**
     * Find Riad by Entreprise
     */
    public function findByEntreprise($slug)
    {
        return $this->riadRepository->findByEntreprise($slug);
    }

    /**
     * Find Riad by Ville
     */
    public function findByVille($slug)
    {
        return $this->riadRepository->findByVille($slug);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreRiadRequest $request, $slug)
    {
        return $this->riadRepository->update($slug, $request->validated());
    }

    /**
     * Update the status of the specified resource in storage.
     */
    public function updateStatus($slug, Request $request)
    {
        return $this->riadRepository->updateStatus($slug, $request->status);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($slug)
    {
        return $this->riadRepository->delete($slug);
    }

    public function findByEmployee()
    {
        return $this->riadRepository->findByEmployee();
    }
}
