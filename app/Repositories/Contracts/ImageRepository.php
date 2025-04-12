<?php

namespace App\Repositories\Contracts;

interface ImageRepository
{
    public function all();
    public function findBySlug(string $slug);
    public function create(array $data);
    public function update($image, array $data);
    public function delete(string $slug);
    public function findByModel(string $model, string $modelId);
    public function storeImage($file, string $path);
}
