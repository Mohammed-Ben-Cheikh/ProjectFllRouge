<?php

namespace App\Repositories\Contracts;

interface EmployeRepository
{
    
    public function all();

    public function findBySlug(string $slug);
   
    public function create(array $data);
    
    public function update($Employe, array $data);
   
    public function delete(string $slug);
    
    public function findByRiad(string $riadSlug);   
}
