<?php

namespace App\Repositories\Contracts;

use App\Models\Chambre;
use App\Traits\HttpResponses;

class ChambreRepositoryData
{
    use HttpResponses;

    public function all()
    {
        return Chambre::all();
    }

    public function findBySlug(string $slug)
    {
        return Chambre::where('slug', $slug)->first();
    }

    public function create(array $data)
    {
        return Chambre::create($data);
    }

    public function update($chambre, array $data)
    {
        $chambre->update($data);
        return $chambre;
    }

    public function delete(string $slug)
    {
        $chambre = Chambre::where('slug', $slug)->first();
        if (!$chambre) {
            return $this->error('', 'Chambre not found', 404);
        }
        $chambre->delete();
        return $this->success('', 'Chambre deleted successfully', 200);
    }

    public function findByRiad(string $riadSlug)
    {
        $chambres = Chambre::where('riad_slug', $riadSlug)->get();
        if ($chambres->isEmpty()) {
            return $this->error('', 'Chambres not found', 404);
        }
        return $chambres;
    }
}
