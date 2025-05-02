<?php

namespace App\Repositories\Contracts;

interface AvisRepository
{
    public function all();
    public function findBySlug(string $slug);
    public function create(array $data);
    public function update($avis, array $data);
    public function delete(string $slug);
    public function findByRiad(string $riadSlug);
    public function findByChambre(string $chambreSlug);
    public function findByService(string $serviceSlug);

    public function findByVille(string $villeSlug);
}
