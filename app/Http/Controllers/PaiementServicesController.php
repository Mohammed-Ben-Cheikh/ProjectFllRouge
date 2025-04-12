<?php

namespace App\Http\Controllers;

use App\Models\paiement_services;
use App\Http\Requests\Storepaiement_servicesRequest;
use App\Http\Requests\Updatepaiement_servicesRequest;

class PaiementServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Storepaiement_servicesRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(paiement_services $paiement_services)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Updatepaiement_servicesRequest $request, paiement_services $paiement_services)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(paiement_services $paiement_services)
    {
        //
    }
}
