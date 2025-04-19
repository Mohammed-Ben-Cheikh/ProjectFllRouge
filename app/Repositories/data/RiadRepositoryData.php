<?php

namespace App\Repositories\data;

use App\Models\Riad;
use App\Models\RiadImages;
use App\Models\User;
use App\Models\Ville;
use App\Traits\HttpResponses;
use App\Repositories\Contracts\RiadRepository;

class RiadRepositoryData implements RiadRepository
{
    use HttpResponses;

    public function all()
    {
        return $this->success(['riads' => Riad::all()], 'Riads retrieved successfully', 200);
    }

    public function findBySlug(string $slug)
    {
        return $this->success(['riad' => static::riad($slug)->first()], 'Riad found successfully', 200);
    }

    public function create(array $data)
    {
        $riad = Riad::create($data);
        if (isset($data['images']) && is_array($data['images'])) {
            $isPrimary = true;
            foreach ($data['images'] as $imageFile) {
                $path = $imageFile->store('riads', 'public');
                RiadImages::create([
                    'riad_id' => $riad->id,
                    'image_url' => $path,
                    'is_primary' => $isPrimary
                ]);
                $isPrimary = false;
            }
        }
        return $this->success(['riad' => $riad->load('images')], 'Riad created successfully', 200);
    }

    public function update($slug, array $data)
    {
        $riad = static::riad($slug)->first();
        if ($riad && $riad->update($data)) {
            return $this->success(['riad' => $riad], 'Riad updated successfully', 200);
        }
        return $this->error('', 'Failed to update riad', 400);
    }

    public function delete(string $slug)
    {
        $riad = static::riad($slug)->first();
        if (!$riad) {
            return $this->error('', 'Riad not found', 404);
        }
        $riad->update(['destroy' => true]);
        return $this->success(['riad' => $riad], 'Riad deleted successfully', 200);
    }

    public function findByEntreprise(string $Slug)
    {
        $riads = Riad::whereHas('entreprise', function ($query) use ($Slug) {
            $query->where('slug', $Slug);
        })->get();

        if ($riads->isEmpty()) {
            return $this->error('', 'No riads found for this entreprise', 404);
        }
        return $riads;
    }

    public function findByVille(string $Slug)
    {
        $riads = Riad::whereHas('ville', function ($query) use ($Slug) {
            $query->where('slug', $Slug);
        })->get();

        if ($riads->isEmpty()) {
            return $this->error('', 'No riads found for this ville', 404);
        }
        return $riads;
    }

    public static function riad($slug)
    {
        return Riad::where('slug', $slug);
    }
}
