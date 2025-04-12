<?php

namespace App\Repositories\data;

use App\Models\Ville;
use App\Traits\HttpResponses;
use App\Repositories\Contracts\VilleRepository;

class VilleRepositoryData implements VilleRepository
{
    use HttpResponses;

    public function all()
    {
        return Ville::all();
    }

    public function findBySlug(string $slug)
    {
        return Ville::where('slug', $slug)->first();
    }

    public function create(array $data)
    {
        return Ville::create($data);
    }

    public function update($ville, array $data)
    {
        $ville->update($data);
        return $ville;
    }

    public function delete(string $slug)
    {
        $ville = $this->findBySlug($slug);
        if ($ville) {
            $ville->delete();
            return true;
        }
        return false;
    }
}
