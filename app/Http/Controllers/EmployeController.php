<?php

namespace App\Http\Controllers;

use App\Models\Employe;
use App\Http\Requests\StoreEmployeRequest;
use App\Http\Requests\UpdateEmployeRequest;
use App\Repositories\Contracts\EmployeRepository;

class EmployeController extends Controller
{
    protected $employeRepository;

    public function __construct(EmployeRepository $employeRepository)
    {
        $this->employeRepository = $employeRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->employeRepository->all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEmployeRequest $request)
    {
        return $this->employeRepository->create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
        return $this->employeRepository->findBySlug($slug);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($slug, StoreEmployeRequest $request)
    {
        return $this->employeRepository->update($slug, $request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($slug)
    {
        return $this->employeRepository->delete($slug);
    }

    /**
     * Find employees by riad
     */
    public function findByRiad($riadSlug)
    {
        return $this->employeRepository->findByRiad($riadSlug);
    }
}
