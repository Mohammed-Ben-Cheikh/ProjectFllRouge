<?php

namespace App\Http\Controllers;

use App\Models\favoris;
use App\Http\Requests\StorefavorisRequest;
use App\Http\Requests\UpdatefavorisRequest;

class FavorisController extends Controller
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
    public function store(StorefavorisRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(favoris $favoris)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatefavorisRequest $request, favoris $favoris)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(favoris $favoris)
    {
        //
    }
}
