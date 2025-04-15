<?php

namespace App\Repositories\data;

use App\Models\Employe;
use App\Models\Riad;
use App\Traits\HttpResponses;
use App\Repositories\Contracts\EmployeRepository;

class EmployeRepositoryData implements EmployeRepository
{
    use HttpResponses;

    public function all()
    {
        return $this->success(['employes' => Employe::all()], 'Employes retrieved successfully', 200);
    }

    public function findBySlug(string $slug)
    {
        $employe = Employe::where('slug', $slug)->first();
        if (!$employe) {
            return $this->error('', 'Employe not found', 404);
        }
        return $this->success(['employe' => $employe], 'Employe found successfully', 200);
    }

    public function create(array $data)
    {
        $employe = Employe::create([
            'nom' => $data['nom'],
            'prenom' => $data['prenom'],
            'email' => $data['email'],
            'telephone' => $data['telephone'],
            'adresse' => $data['adresse'],
            'poste' => $data['poste'],
            'salaire' => $data['salaire'],
            'date_embauche' => $data['date_embauche'],
            'riad_id' => $data['riad_id'],
            'entreprise_id' => $data['entreprise_id'],
            'user_id' => $data['user_id']
        ]);

        return $this->success(['employe' => $employe], 'Employe created successfully', 201);
    }

    public function update($employe, array $data)
    {
        if (!$employe->update($data)) {
            return $this->error('', 'Failed to update employe', 400);
        }
        return $this->success(['employe' => $employe], 'Employe updated successfully', 200);
    }

    public function delete(string $slug)
    {
        $employe = Employe::where('slug', $slug)->first();
        if (!$employe) {
            return $this->error('', 'Employe not found', 404);
        }
        $employe->delete();
        return $this->success('', 'Employe deleted successfully', 200);
    }

    public function findByRiad(string $riadSlug)
    {
        $employes = Employe::whereHas('riad', function ($query) use ($riadSlug) {
            $query->where('slug', $riadSlug);
        })->get();

        if ($employes->isEmpty()) {
            return $this->error('', 'No employes found for this riad', 404);
        }
        return $this->success(['employes' => $employes], 'Employes found successfully', 200);
    }
}
