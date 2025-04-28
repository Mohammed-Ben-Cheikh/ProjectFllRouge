<?php

namespace App\Repositories\data;

use App\Models\Chambre;
use App\Models\ChambreImages;
use App\Models\Employe;
use App\Models\Riad;
use App\Traits\HttpResponses;
use App\Repositories\Contracts\ChambreRepository;

class ChambreRepositoryData implements ChambreRepository
{
    use HttpResponses;

    public function all()
    {
        return $this->success(['chambres' => Chambre::with('images')->get()], 'Chambres retrieved successfully', 200);
    }

    public function findBySlug(string $slug)
    {
        $chambre = Chambre::where('slug', $slug)->first();
        if (!$chambre) {
            return $this->error('', 'Chambre not found', 404);
        }
        return $this->success(['chambre' => $chambre], 'Chambre found successfully', 200);
    }

    public function create(array $data)
    {
        // return $this->error($data, 'Chambre not found', 404);
        $data['equipements'] = json_encode($data['equipements']);
        $data['riad_id'] = static::employe('riad')->id;
        $chambre = Chambre::create($data);
        if ($chambre) {
            if (isset($data['images']) && is_array($data['images'])) {
                $isPrimary = true;
                foreach ($data['images'] as $imageFile) {
                    $path = $imageFile->store('chambres', 'public');
                    ChambreImages::create([
                        'chambre_id' => $chambre->id,
                        'image_url' => $path,
                        'is_primary' => $isPrimary
                    ]);
                    $isPrimary = false;
                }
            }
            return $this->success(['chambre' => $chambre->load('images')], 'Chambre created successfully', 201);
        } else
            return $this->error('', 'Failed to create chambre', 400);
    }

    public function update($chambre, array $data)
    {
        if (!$chambre->update($data)) {
            return $this->error('', 'Failed to update chambre', 400);
        }
        return $this->success(['chambre' => $chambre], 'Chambre updated successfully', 200);
    }

    public function delete(string $slug)
    {
        $chambre = Chambre::where('slug', $slug)->first();
        if (!$chambre) {
            return $this->error('', 'Chambre not found', 404);
        }
        $chambre->delete();
        return $this->success('', 'Chambre deleted successfully', 200);
    }

    public function findByRiad(string $riadSlug)
    {
        $chambres = Chambre::whereHas('riad', function ($query) use ($riadSlug) {
            $query->where('slug', $riadSlug);
        })->get();

        if ($chambres->isEmpty()) {
            return $this->error('', 'No chambres found for this riad', 404);
        }
        return $this->success(['chambres' => $chambres], 'Chambres found successfully', 200);
    }

    public function findByEmployee()
    {
        $chambres = static::employe('chambres');
        if ($chambres->isEmpty()) {
            return $this->error(['chambres' => $chambres], 'No chambres found for this employee', 404);
        }
        return $this->success(['chambres' => $chambres->load('images')], 'Chambres found successfully', 200);
    }

    static function employe($data)
    {
        $user = auth()->user();
        $employe = Employe::where('user_id', $user->id)->first();
        if ($data == 'riad') {
            return Riad::where('id', $employe->riad_id)->first();
        } elseif ($data == 'chambres') {
            return Chambre::where('riad_id', static::employe('riad')->id)->get();
        } else {
            return null;
        }
    }

    public function updateStatus(string $slug, array $data)
    {
        $chambre = Chambre::where('slug', $slug)->first();
        if (!$chambre) {
            return $this->error(null, 'Chambre not found', 404);
        }

        if (isset($data['statut'])) {
            $chambre->statut = $data['statut'];
            $chambre->save();
        }

        return $this->success(['chambre' => $chambre], 'Chambre status updated successfully', 200);
    }
}
