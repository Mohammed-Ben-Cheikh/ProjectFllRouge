<?php

namespace App\Repositories\Contracts;

interface ReservationRepository
{

    public function all();

    public function findBySlug(string $slug);

    public function create(array $data);

    public function update($category, array $data);

    public function delete(string $slug);

    public function findByRiad(string $riadSlug);
}
