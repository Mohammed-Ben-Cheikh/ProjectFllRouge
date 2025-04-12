<?php

namespace App\Repositories\data;

use App\Models\Favoris;
use App\Traits\HttpResponses;
use App\Repositories\Contracts\FavorisRepository;

class FavorisRepositoryData implements FavorisRepository
{
    use HttpResponses;

    public function all()
    {
        return Favoris::all();
    }

    public function findBySlug(string $slug)
    {
        return Favoris::where('slug', $slug)->first();
    }

    public function create(array $data)
    {
        return Favoris::create($data);
    }

    public function delete(string $slug)
    {
        $favoris = $this->findBySlug($slug);
        if (!$favoris) {
            return $this->error('', 'Favoris not found', 404);
        }
        $favoris->delete();
        return $this->success('', 'Favoris deleted successfully', 200);
    }

    public function findByUser(string $userSlug)
    {
        $favoris = Favoris::whereHas('user', function($query) use ($userSlug) {
            $query->where('slug', $userSlug);
        })->get();

        if ($favoris->isEmpty()) {
            return $this->error('', 'No favoris found for this user', 404);
        }
        return $favoris;
    }

    public function findByRiad(string $riadSlug)
    {
        $favoris = Favoris::whereHas('riad', function($query) use ($riadSlug) {
            $query->where('slug', $riadSlug);
        })->get();

        if ($favoris->isEmpty()) {
            return $this->error('', 'No favoris found for this riad', 404);
        }
        return $favoris;
    }
}
