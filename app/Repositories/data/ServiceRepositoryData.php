<?php

namespace App\Repositories\data;

use App\Models\Riad;
use App\Models\Chambre;
use App\Models\Employe;
use App\Models\Service;
use App\Models\ServiceImages;
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
        $data['riad_id'] = static::employe('riad')->id;
        $service = Service::create($data);
        if ($service) {
            if (isset($data['images']) && is_array($data['images'])) {
                $isPrimary = true;
                foreach ($data['images'] as $imageFile) {
                    $path = $imageFile->store('services', 'public');
                    ServiceImages::create([
                        'service_id' => $service->id,
                        'image_url' => $path,
                        'is_primary' => $isPrimary
                    ]);
                    $isPrimary = false;
                }
            }
            return $this->success(['service' => $service->load('images')], 'Service created successfully', 201);
        } else
            return $this->error(null, 'Failed to create chambre', 400);
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

    public function findByEmployee()
    {
        $services = Service::where('riad_id', static::employe('riad')->id)->get();

        if ($services->isEmpty()) {
            return $this->error('', 'No services found for this employee', 404);
        }
        return $this->success(['services' => $services->load('images')], 'Services found successfully', 200);
    }


    static function employe($data)
    {
        $user = auth()->user();
        $employe = Employe::where('user_id', $user->id)->first();
        if ($data == 'riad') {
            return Riad::where('id', $employe->riad_id)->first();
        } else {
            return null;
        }
    }
}
