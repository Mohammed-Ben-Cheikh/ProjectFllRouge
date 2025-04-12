<?php

namespace App\Repositories\Contracts;

use App\Models\Employe;
use App\Models\Riad;
use App\Traits\HttpResponses;

interface EmployeRepositoryData
{
    use HttpResponses;

    public function all()
    {
        return Employe::all();
    }

    public function findBySlug(string $username)
    {
        return Employe::where('username', $username)->first();
    }

    public function create(array $data)
    {
        return Employe::create($data);
    }

    public function update($Employe, array $data)
    {
        $Employe->update($data);
        return $Employe;
    }

    public function delete(string $username)
    {
        $Employe = Employe::where('username', $username)->first();
        if (!$Employe) {
            return $this->error('', 'Employe not found', 404);
        }
        $Employe->delete();
        return $this->success('', 'Employe deleted successfully', 200);
    }

    public function findByRiad(string $riadSlug)
    {
        $Employes = Employe::where('riad_id', Riad::where('slug', $riadSlug)->first())->get();
        if ($Employes->isEmpty()) {
            return $this->error('', 'Employes not found', 404);
        }
        return $Employes;
    }
}
