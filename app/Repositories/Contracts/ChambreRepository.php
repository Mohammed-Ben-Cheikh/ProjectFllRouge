<?php

namespace App\Repositories\Contracts;

interface ChambreRepository
{
    public function all();
    public function findBySlug(string $slug);
    public function create(array $data);
    public function update($category, array $data);
    public function delete(string $slug);
    public function findByRiad(string $riadSlug);
    public function findByEmployee();
    public function updateStatus(string $slug, array $data);
}
