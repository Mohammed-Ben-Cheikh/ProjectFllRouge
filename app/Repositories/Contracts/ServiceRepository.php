<?php

namespace App\Repositories\Contracts;

interface ServiceRepository
{
    public function all();
    public function findBySlug(string $slug);
    public function create(array $data);
    public function update($service, array $data);
    public function delete(string $slug);
    public function findByEntreprise(string $entrepriseSlug);
}
