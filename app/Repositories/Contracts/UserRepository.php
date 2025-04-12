<?php

namespace App\Repositories\Contracts;

interface UserRepository
{
    public function all();
    public function findBySlug(string $slug);
    public function create(array $data);
    public function update($user, array $data);
    public function delete(string $slug);
    public function findByRole(string $role);
    public function findByEmail(string $email);
}
