<?php

namespace App\Http\Controllers;

use App\Models\Employe;
use Illuminate\Http\Request;
use App\Http\Requests\StoreEmployeRequest;
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
    public function store(Request $request) // Corrected 'request()' to 'Request'
    {
        return $this->employeRepository->create($request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($slug)
    {
        return $this->employeRepository->delete($slug);
    }

    /**
     * Display the user employes.
     */
    public function findUser()
    {
        return $this->employeRepository->findUser();
    }
}
