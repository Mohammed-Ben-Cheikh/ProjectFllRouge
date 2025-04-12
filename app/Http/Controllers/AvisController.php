<?php

namespace App\Http\Controllers;

use App\Models\avis;
use App\Http\Requests\StoreavisRequest;
use App\Http\Requests\UpdateavisRequest;

class AvisController extends Controller
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
    public function store(StoreavisRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(avis $avis)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateavisRequest $request, avis $avis)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(avis $avis)
    {
        //
    }
}
