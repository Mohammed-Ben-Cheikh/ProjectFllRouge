<?php

namespace App\Repositories\data;

use App\Models\User;
use App\Traits\HttpResponses;
use App\Repositories\Contracts\UserRepository;

class UserRepositoryData implements UserRepository
{
    use HttpResponses;

    public function all()
    {
        return User::all();
    }

    public function findBySlug(string $slug)
    {
        return User::where('slug', $slug)->first();
    }

    public function create(array $data)
    {
        return User::create($data);
    }

    public function update($user, array $data)
    {
        $user->update($data);
        return $user;
    }

    public function delete(string $slug)
    {
        $user = $this->findBySlug($slug);
        if (!$user) {
            return $this->error('', 'User not found', 404);
        }
        $user->delete();
        return $this->success('', 'User deleted successfully', 200);
    }

    public function findByRole(string $role)
    {
        $users = User::where('role', $role)->get();
        if ($users->isEmpty()) {
            return $this->error('', 'No users found with this role', 404);
        }
        return $users;
    }

    public function findByEmail(string $email)
    {
        return User::where('email', $email)->first();
    }
}
