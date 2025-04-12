<?php

namespace App\Repositories\Contracts;

interface FavorisRepository
{
    public function all();
    public function findBySlug(string $slug);
    public function create(array $data);
    public function delete(string $slug);
    public function findByUser(string $userSlug);
    public function findByRiad(string $riadSlug);
}
