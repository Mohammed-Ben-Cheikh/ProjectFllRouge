<?php

namespace App\Http\Controllers;

use App\Models\favoris;
use App\Http\Requests\StorefavorisRequest;
use App\Repositories\Contracts\FavorisRepository;

class FavorisController extends Controller
{
    protected $favorisRepository;

    public function __construct(FavorisRepository $favorisRepository)
    {
        $this->favorisRepository = $favorisRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->favorisRepository->all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorefavorisRequest $request)
    {
        return $this->favorisRepository->create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
        return $this->favorisRepository->findBySlug($slug);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($slug)
    {
        return $this->favorisRepository->delete($slug);
    }

    /**
     * Find favoris by user
     */
    public function findByUser($userSlug)
    {
        return $this->favorisRepository->findByUser($userSlug);
    }

    /**
     * Find favoris by riad
     */
    public function findByRiad($riadSlug)
    {
        return $this->favorisRepository->findByRiad($riadSlug);
    }
}
