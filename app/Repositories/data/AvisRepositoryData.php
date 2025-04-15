<?php

namespace App\Repositories\data;

use App\Models\AvisRiads;
use App\Models\AvisChambers;
use App\Models\AvisServices;
use App\Traits\HttpResponses;
use App\Repositories\Contracts\AvisRepository;

class AvisRepositoryData implements AvisRepository
{
    use HttpResponses;

    public function all()
    {
        $avisRiads = AvisRiads::all();
        $avisChambers = AvisChambers::all();
        $avisServices = AvisServices::all();
        return collect([$avisRiads, $avisChambers, $avisServices])->flatten();
    }

    public function findBySlug(string $slug)
    {
        return AvisRiads::where('slug', $slug)
            ->orWhere(function($query) use ($slug) {
                $query->from('avis_chambers')->where('slug', $slug);
            })
            ->orWhere(function($query) use ($slug) {
                $query->from('avis_services')->where('slug', $slug);
            })
            ->first();
    }

    public function create(array $data)
    {
        switch($data['type']) {
            case 'riad':
                return AvisRiads::create($data);
            case 'chambre':
                return AvisChambers::create($data);
            case 'service':
                return AvisServices::create($data);
            default:
                return $this->error('Invalid avis type', 400);
        }
    }

    public function update($avis, array $data)
    {
        $avis->update($data);
        return $avis;
    }

    public function delete(string $slug)
    {
        $avis = $this->findBySlug($slug);
        if (!$avis) {
            return $this->error('Avis not found', 404);
        }
        $avis->delete();
        return $this->success('Avis deleted successfully', 200);
    }

    public function findByRiad(string $riadSlug)
    {
        $avis = AvisRiads::where('slug', $riadSlug)->get();
        if ($avis->isEmpty()) {
            return $this->error('No avis found for this riad', 404);
        }
        return $avis;
    }

    public function findByChambre(string $chambreSlug)
    {
        $avis = AvisChambers::where('slug', $chambreSlug)->get();
        if ($avis->isEmpty()) {
            return $this->error('No avis found for this chambre', 404);
        }
        return $avis;
    }

    public function findByService(string $serviceSlug)
    {
        $avis = AvisServices::where('slug', $serviceSlug)->get();
        if ($avis->isEmpty()) {
            return $this->error('No avis found for this service', 404);
        }
        return $avis;
    }
}
