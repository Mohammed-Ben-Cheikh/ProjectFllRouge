<?php

namespace App\Repositories\data;

use App\Models\AvisRiads;
use App\Models\AvisChambers;
use App\Models\AvisServices;
use App\Models\Chambre;
use App\Models\Riad;
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
                return $this->error('Invalid avis type', 400, null);
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
            return $this->error('Avis not found', 404, null);
        }
        $avis->delete();
        return $this->success('Avis deleted successfully', 200);
    }

    public function findByRiad(string $riadSlug)
    {
        $riad = Riad::where('slug', $riadSlug)->first();
        $avis = AvisRiads::where('riad_id', '=', $riad->id)->get();
        if ($avis->isEmpty()) {
            return $this->error(null, 'No avis found for this riad', 404);
        }
        return $this->success(['avis' => $avis], 'Avis found successfully', 200);
    }

    public function findByChambre(string $chambreSlug)
    {
        $chamber = Chambre::where('slug', $chambreSlug)->first();
        $avis = AvisChambers::where('chamber_id', $chamber->id)->get();
        if ($avis->isEmpty()) {
            return $this->error(null, 'No avis found for this chambre', 404);
        }
        return $this->success(['avis' => $avis], 'Avis found successfully', 200);
    }

    public function findByService(string $serviceSlug)
    {
        $avis = AvisServices::where('slug', $serviceSlug)->get();
        if ($avis->isEmpty()) {
            return $this->error(null, 'No avis found for this service', 404);
        }
        return $this->success(['avis' => $avis], 'Avis found successfully', 200);
    }

    public function findByVille(string $villeSlug)
    {
        $riads = Riad::where('slug', $villeSlug)->get();
        if ($riads->isEmpty()) {
            return $this->error(null, 'No riads found for this ville', 404);
        }
        $avis = AvisRiads::whereIn('riad_id', $riads->pluck('id'))->get();
        if ($avis->isEmpty()) {
            return $this->error(null, 'No avis found for this ville', 404);
        }
        return $this->success(['avis' => $avis], 'Avis found successfully', 200);
    }


}
