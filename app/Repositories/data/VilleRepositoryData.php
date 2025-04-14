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
        return $this->success(['villes' => Ville::all()], '', 200);
    }

    public function findBySlug(string $slug)
    {
        return $this->success(['ville' => Ville::where('slug', $slug)->first()], 'Ville found successfully', 200);
    }

    public function create(array $data)
    {
        if ($ville = Ville::create($data)) {
            return $this->success(['ville' => $ville], 'Ville created successfully', 200);
        } else
            return $this->error(null, 'Failed to create ville');
    }

    public function update($slug, array $data)
    {
        $ville = Ville::where('slug', $slug)->first();
        if (!$ville) {
            return $this->error(null, 'Ville not found', 404);
        }
        $ville->update($data);
        return $this->success(['ville' => $ville], 'Ville updated successfully', 200);
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
