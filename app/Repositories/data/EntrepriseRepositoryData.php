<?php

namespace App\Repositories\data;

use App\Models\Entreprise;
use App\Models\User;
use App\Traits\HttpResponses;
use App\Repositories\Contracts\EntrepriseRepository;
use Illuminate\Support\Facades\Auth;

class EntrepriseRepositoryData implements EntrepriseRepository
{
    use HttpResponses;

    public function all()
    {
        return $this->success(['entreprises' => Entreprise::all()], 'Entreprises retrieved successfully', 200);

    }

    public function findBySlug(string $slug)
    {
        return $this->success(['entreprise' => static::entreprise($slug)->first()], 'Entreprise found successfully', 200);
    }

    public function create(array $data)
    {
        $data['user_id'] = Auth::id();
        if ($entreprise = Entreprise::create($data)) {
            return $this->success(['entreprise' => $entreprise], 'Entreprise created successfully', 200);
        } else
            return $this->error(null, 'Failed to create entreprise');
    }

    public function update($slug, array $data)
    {
        $entreprise = static::entreprise($slug);
        if ($entreprise->update($data)) {
            return $this->success(['entreprise' => static::entreprise($slug)->first()], 'Entreprise updated successfully', 200);
        } else
            return $this->error(null, 'Failed to update entreprise');
    }

    public function delete(string $slug)
    {
        $entreprise = static::entreprise($slug);
        if (!$entreprise) {
            return $this->error(null, 'Entreprise not found', 404);
        }
        $entreprise->update(['destroy' => true]);
        return $this->success(['entreprise' => $entreprise], 'Entreprise deleted successfully', 200);
    }


    public function findByUser()
    {
        $id = Auth::id();
        $entreprises = Entreprise::whereHas('user', function ($query) use ($id) {
            $query->where('id', $id);
        })->get();

        if ($entreprises->isEmpty()) {
            return $this->error(null, 'No entreprises found for this user', 404);
        }
        return $entreprises;
    }

    public static function entreprise($slug)
    {
        return Entreprise::where('slug', $slug);
    }
}
