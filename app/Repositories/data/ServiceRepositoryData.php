<?php

namespace App\Repositories\data;

use App\Models\Service;
use App\Traits\HttpResponses;
use App\Repositories\Contracts\ServiceRepository;

class ServiceRepositoryData implements ServiceRepository
{
    use HttpResponses;

    public function all()
    {
        return Service::all();
    }

    public function findBySlug(string $slug)
    {
        return Service::where('slug', $slug)->first();
    }

    public function create(array $data)
    {
        return Service::create($data);
    }

    public function update($service, array $data)
    {
        $service->update($data);
        return $service;
    }

    public function delete(string $slug)
    {
        $service = Service::where('slug', $slug)->first();
        if (!$service) {
            return $this->error('', 'Service not found', 404);
        }
        $service->delete();
        return $this->success('', 'Service deleted successfully', 200);
    }

    public function findByEntreprise(string $entrepriseSlug)
    {
        $services = Service::whereHas('entreprise', function($query) use ($entrepriseSlug) {
            $query->where('slug', $entrepriseSlug);
        })->get();

        if ($services->isEmpty()) {
            return $this->error('', 'No services found for this entreprise', 404);
        }
        return $services;
    }
}
