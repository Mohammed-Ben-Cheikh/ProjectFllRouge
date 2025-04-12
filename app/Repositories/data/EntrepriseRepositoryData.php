<?php

namespace App\Repositories\data;

use App\Models\Entreprise;
use App\Traits\HttpResponses;
use App\Repositories\Contracts\EntrepriseRepository;

class EntrepriseRepositoryData implements EntrepriseRepository
{
    use HttpResponses;

    public function all()
    {
        return Entreprise::all();
    }

    public function findBySlug(string $slug)
    {
        return Entreprise::where('slug', $slug)->first();
    }

    public function create(array $data)
    {
        return Entreprise::create($data);
    }

    public function update($entreprise, array $data)
    {
        $entreprise->update($data);
        return $entreprise;
    }

    public function delete(string $slug)
    {
        $entreprise = $this->findBySlug($slug);
        if (!$entreprise) {
            return $this->error('', 'Entreprise not found', 404);
        }
        $entreprise->delete();
        return $this->success('', 'Entreprise deleted successfully', 200);
    }

    public function findByUser(string $userSlug)
    {
        $entreprises = Entreprise::whereHas('user', function($query) use ($userSlug) {
            $query->where('slug', $userSlug);
        })->get();

        if ($entreprises->isEmpty()) {
            return $this->error('', 'No entreprises found for this user', 404);
        }
        return $entreprises;
    }
}
