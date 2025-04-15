<?php

namespace App\Repositories\Contracts;

interface EntrepriseRepository
{
    public function all();
    public function findBySlug(string $slug);
    public function addImage(string $slug, $data);
    public function create(array $data);
    public function update($slug, array $data);
    public function delete(string $slug);
    public function findByUser();
}
