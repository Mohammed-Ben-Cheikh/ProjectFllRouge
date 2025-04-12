<?php

namespace App\Repositories\Contracts;

interface RiadRepository
{
   
    public function all();
  
    public function findBySlug(string $slug);
   
    public function create(array $data);
   
    public function update($Riad, array $data);
   
    public function delete(string $slug);
 
    public function findByUser(string $username);
    
    public function findByVille(string $villeSlug);
}
