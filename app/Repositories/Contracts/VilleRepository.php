<?php

namespace App\Repositories\Contracts;

interface VilleRepository
{

    public function all();

    public function findBySlug(string $slug);

    public function create(array $data);

    public function update($category, array $data);

    public function delete(string $slug);
}
