<?php

namespace App\Repositories\Contracts;

interface ReservationRepository
{
    public function all();
    public function findBySlug(string $slug);
    public function create(array $data);
    public function update($reservation, array $data);
    public function delete(string $slug);
    public function findByUser(string $userSlug);
    public function findByChambre(string $chambreSlug);
    public function findByStatus(string $status);
}
