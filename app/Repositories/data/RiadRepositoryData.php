<?php

namespace App\Repositories\data;

use App\Models\Riad;
use App\Models\User;
use App\Models\Ville;
use App\Traits\HttpResponses;
use App\Repositories\Contracts\RiadRepository;

class RiadRepositoryData implements RiadRepository
{
    use HttpResponses;

    public function all()
    {
        return Riad::all();
    }

    public function findBySlug(string $slug)
    {
        return Riad::where('slug', $slug)->first();
    }

    public function create(array $data)
    {
        return Riad::create($data);
    }

    public function update($riad, array $data)
    {
        $riad->update($data);
        return $riad;
    }

    public function delete(string $slug)
    {
        $riad = $this->findBySlug($slug);
        if (!$riad) {
            return $this->error('', 'Riad not found', 404);
        }
        $riad->delete();
        return $this->success('', 'Riad deleted successfully', 200);
    }

    public function findByUser(string $userSlug)
    {
        $riads = Riad::whereHas('user', function($query) use ($userSlug) {
            $query->where('slug', $userSlug);
        })->get();

        if ($riads->isEmpty()) {
            return $this->error('', 'No riads found for this user', 404);
        }
        return $riads;
    }

    public function findByVille(string $villeSlug)
    {
        $riads = Riad::whereHas('ville', function($query) use ($villeSlug) {
            $query->where('slug', $villeSlug);
        })->get();

        if ($riads->isEmpty()) {
            return $this->error('', 'No riads found in this ville', 404);
        }
        return $riads;
    }
}
