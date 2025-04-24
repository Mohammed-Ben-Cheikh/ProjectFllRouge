<?php

namespace App\Repositories\Contracts;

interface EmployeRepository
{
    public function all();

    public function create(array $data);

    public function delete(string $slug);

    public function findUser();
}
