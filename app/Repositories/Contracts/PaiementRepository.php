<?php

namespace App\Repositories\Contracts;

interface PaiementRepository
{
    public function all();
    public function findBySlug(string $slug);
    public function create(array $data);
    public function update($paiement, array $data);
    public function delete(string $slug);
    public function findByReservation(string $reservationSlug);
    public function findByUser(string $userSlug);
}
