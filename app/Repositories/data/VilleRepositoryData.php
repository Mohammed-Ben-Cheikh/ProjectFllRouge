<?php

namespace App\Repositories\data;

use App\Models\Ville;
use App\Models\VilleImages;
use App\Traits\HttpResponses;
use App\Repositories\Contracts\VilleRepository;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class VilleRepositoryData implements VilleRepository
{
    use HttpResponses;

    public function all()
    {
        return $this->success(['villes' => Ville::with('images')->get()], 'Villes retrieved successfully', 200);
    }

    public function findBySlug(string $slug)
    {
        $ville = Ville::with('images', 'riads')->where('slug', $slug)->first();
        if (!$ville) {
            return $this->error('', 'Ville not found', 404);
        }
        return $this->success(['ville' => $ville], 'Ville found successfully', 200);
    }

    public function create(array $data)
    {
        $ville = Ville::create([
            'nom' => $data['nom'],
            'description' => $data['description']
        ]);
        if (isset($data['images']) && is_array($data['images'])) {
            $isPrimary = true;
            foreach ($data['images'] as $imageFile) {
                $path = $imageFile->store('villes', 'public');
                VilleImages::create([
                    'ville_id' => $ville->id,
                    'image_url' => $path,
                    'is_primary' => $isPrimary
                ]);
                $isPrimary = false;
            }
        }
        return $this->success(['ville' => $ville->load('images')], 'Ville created successfully', 201);
    }

    public function update($ville, array $data)
    {
        if (!$ville->update($data)) {
            return $this->error('', 'Failed to update ville', 400);
        }
        if (isset($data['images']) && is_array($data['images'])) {
            foreach ($data['images'] as $imageFile) {
                $path = $imageFile->store('villes', 'public');
                VilleImages::create([
                    'ville_id' => $ville->id,
                    'image_url' => $path,
                    'is_primary' => false
                ]);
            }
        }
        return $this->success(['ville' => $ville->load('images')], 'Ville updated successfully', 200);
    }

    public function delete(string $slug)
    {
        $ville = Ville::where('slug', $slug)->first();
        if (!$ville) {
            return $this->error('', 'Ville not found', 404);
        }

        // Delete associated images from storage
        foreach ($ville->images as $image) {
            Storage::delete($image->image_url);
            $image->delete();
        }

        $ville->delete();
        return $this->success('', 'Ville deleted successfully', 200);
    }

    public function search(string $term)
    {
        $villes = Ville::with('images')
            ->where('nom', 'like', '%' . $term . '%')
            ->orWhere('description', 'like', '%' . $term . '%')
            ->get();

        if ($villes->isEmpty()) {
            return $this->error('', 'No villes found matching the search term', 404);
        }
        return $this->success(['villes' => $villes], 'Villes found successfully', 200);
    }

    public function getMostPopular()
    {
        $popularVilles = Ville::withCount('riads')
            ->having('riads_count', '>', 0)
            ->orderBy('riads_count', 'desc')
            ->take(5)
            ->get();

        if ($popularVilles->isEmpty()) {
            return $this->error('', 'No popular villes found', 404);
        }
        return $this->success(['villes' => $popularVilles], 'Popular villes retrieved successfully', 200);
    }
}
