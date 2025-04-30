<?php

namespace App\Repositories\Contracts;

interface RiadRepository
{

    public function all();

    public function findBySlug(string $slug);

    public function findUser();

    public function create(array $data);

    public function update($slug, array $data);

    public function delete(string $slug);

    public function findByEntreprise(string $slug);

    public function findByVille(string $villeSlug);

    public function updateStatus($slug, string $status);

    public function findByEmployee();

    public function images();
}
