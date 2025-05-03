<?php

namespace App\Repositories\Contracts;

interface ReservationRepository
{
    public function all();
    public function create(array $data);
    public function update($reservation, array $data);
    public function delete(string $slug);
    public function findByUser();
    public function updateStatus(string $invoice, string $status);
    public function findByChambre(string $chambreSlug);
    public function createServiceReservation(array $data);
    public function updateServiceReservation($reservation, array $data);
    public function deleteServiceReservation(string $slug);
    public function findServiceReservationByUser();
    public function updateServiceReservationStatus(string $invoice, string $status);
    public function findByService(string $serviceSlug);
    public function findByRiad();
}
