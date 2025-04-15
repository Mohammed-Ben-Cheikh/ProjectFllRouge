<?php

namespace App\Repositories\data;

use App\Models\Chambre;
use App\Models\ChambreImages;
use App\Traits\HttpResponses;
use App\Repositories\Contracts\ChambreRepository;

class ChambreRepositoryData implements ChambreRepository
{
    use HttpResponses;

    public function all()
    {
        return $this->success(['chambres' => Chambre::all()], 'Chambres retrieved successfully', 200);
    }

    public function findBySlug(string $slug)
    {
        $chambre = Chambre::where('slug', $slug)->first();
        if (!$chambre) {
            return $this->error('', 'Chambre not found', 404);
        }
        return $this->success(['chambre' => $chambre], 'Chambre found successfully', 200);
    }

    public function create(array $data)
    {
        $chambre = Chambre::create([
            'nom' => $data['nom'],
            'description' => $data['description'],
            'prix' => $data['prix'],
            'capacite' => $data['capacite'],
            'disponibilite' => $data['disponibilite'] ?? true,
            'riad_id' => $data['riad_id']
        ]);

        if (isset($data['images']) && is_array($data['images'])) {
            $isPrimary = true;
            foreach ($data['images'] as $imageFile) {
                $path = $imageFile->store('chambres', 'public');

                ChambreImages::create([
                    'chambre_id' => $chambre->id,
                    'image_url' => $path,
                    'is_primary' => $isPrimary
                ]);

                $isPrimary = false;
            }
        }

        return $this->success(['chambre' => $chambre->load('images')], 'Chambre created successfully', 201);
    }

    public function update($chambre, array $data)
    {
        if (!$chambre->update($data)) {
            return $this->error('', 'Failed to update chambre', 400);
        }
        return $this->success(['chambre' => $chambre], 'Chambre updated successfully', 200);
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
        $chambres = Chambre::whereHas('riad', function($query) use ($riadSlug) {
            $query->where('slug', $riadSlug);
        })->get();

        if ($chambres->isEmpty()) {
            return $this->error('', 'No chambres found for this riad', 404);
        }
        return $this->success(['chambres' => $chambres], 'Chambres found successfully', 200);
    }
}
