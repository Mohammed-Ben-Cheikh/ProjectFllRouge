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
        return Riad::where('slug', $slug)->delete();
    }

    public function findByUser(string $username)
    {
        // Check if the username is empty
        if (empty($username)) {
            return $this->error('', 'username is required', 400);
        }
        // Check if the username is valid
        if (!is_string($username)) {
            return $this->error('', 'username must be a string', 400);
        }
        if (!$user = User::where('username', $username)->first()) {
            return $this->error('', 'user not found', 404);
        }
        // Check if the user has a riad
        if (!Riad::where('user_id', $username)->exists()) {
            return $this->error('', 'username has no riad', 404);
        }
        return Riad::where('user_id', $user)->get();
    }

    public function findByVille(string $villeSlug)
    {
        // Check if the username is empty
        if (empty($villeSlug)) {
            return $this->error('', 'ville slug is required', 400);
        }
        // Check if the username is valid
        if (!is_string($villeSlug)) {
            return $this->error('', 'ville slug must be a string', 400);
        }
        if (!$ville = Ville::where('slug', $villeSlug)->first()) {
            return $this->error('', 'ville not found', 404);
        }
        // Check if the user has a riad
        if (!Riad::where('ville_id', $villeSlug)->exists()) {
            return $this->error('', 'ville slug has no riad', 404);
        }
        return Riad::where('ville_id', $ville)->get();
    }

}