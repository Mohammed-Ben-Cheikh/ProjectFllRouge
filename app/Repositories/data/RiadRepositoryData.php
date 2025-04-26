<?php

namespace App\Repositories\data;

use App\Models\Entreprise;
use App\Models\Riad;
use App\Models\RiadImages;
use App\Models\User;
use App\Models\Ville;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use App\Traits\HttpResponses;
use App\Repositories\Contracts\RiadRepository;
use DB;

class RiadRepositoryData implements RiadRepository
{
    use HttpResponses;

    public function all()
    {
        $riads = Riad::with(['images', 'entreprise', 'ville'])->get();
        return $this->success(['riads' => $riads], 'Riads retrieved successfully', 200);
    }

    public function findBySlug(string $slug)
    {
        return $this->success(['riad' => static::riad($slug)->first()], 'Riad found successfully', 200);
    }

    public function findUser()
    {
        $user = auth()->user();
        if (!$user) {
            return $this->error('', 'User not found', 404);
        }
        $riads = collect();
        $entreprises = Entreprise::where('user_id', $user->id)->get();
        foreach ($entreprises as $entreprise) {
            $riads = $riads->merge(Riad::where('entreprise_id', $entreprise->id)->with('images')->get());
        }
        return $this->success(['riads' => $riads], 'Riads found successfully', 200);
    }

    public function create(array $data)
    {
        if(!$city = Ville::where('id', $data['ville_id'])->first()->city) {
            return $this->error('', 'City not found', 404);
        }
        $data['city'] = $city;
        // return $this->error($data, 'test', 404);
        $riad = Riad::create($data);
        if (!$riad) {
            return $this->error('', 'Failed to create riad', 400);
        }
        if (isset($data['images']) && is_array($data['images'])) {
            $isPrimary = true;
            foreach ($data['images'] as $imageFile) {
                $path = $imageFile->store('riads', 'public');
                RiadImages::create([
                    'riad_id' => $riad->id,
                    'image_url' => $path,
                    'is_primary' => $isPrimary
                ]);
                $isPrimary = false;
            }
        }
        if (!$riad) {
            return $this->error('', 'Failed to create riad', 400);
        }
        return $this->success(['riad' => $riad->load('images')], 'Riad created successfully', 200);
    }

    public function update($slug, array $data)
    {
        $riad = static::riad($slug)->first();
        if ($riad && $riad->update($data)) {
            return $this->success(['riad' => $riad], 'Riad updated successfully', 200);
        }
        return $this->error('', 'Failed to update riad', 400);
    }

    public function delete(string $slug)
    {
        $riad = static::riad($slug)->first();
        if (!$riad) {
            return $this->error('', 'Riad not found', 404);
        }
        $riad->update(['destroy' => true]);
        return $this->success(['riad' => $riad], 'Riad deleted successfully', 200);
    }

    public function findByEntreprise(string $Slug)
    {
        $riads = Riad::whereHas('entreprise', function ($query) use ($Slug) {
            $query->where('slug', $Slug);
        })->get();

        if ($riads->isEmpty()) {
            return $this->error('', 'No riads found for this entreprise', 404);
        }
        return $riads;
    }

    public function findByVille(string $Slug)
    {
        $riads = Riad::whereHas('ville', function ($query) use ($Slug) {
            $query->where('slug', $Slug);
        })->get();

        if ($riads->isEmpty()) {
            return $this->error('', 'No riads found for this ville', 404);
        }
        return $riads;
    }

    public function updateStatus($slug, string $status)
    {
        $data = ['status' => $status];
        $validator = Validator::make($data, [
            'status' => 'required|string|in:approved,pending,rejected',
        ]);
        if ($validator->fails()) {
            return $this->error($validator->errors(), 'Validation failed', 422);
        }
        $riad = static::riad($slug)->first();
        if (!$riad) {
            return $this->error(null, 'Riad not found', 404);
        }
        if ($riad->update($data)) {
            return $this->success(['riad' => $riad], 'Riad status updated successfully', 200);
        } else {
            return $this->error(null, 'Failed to update riad status', 400);
        }
    }

    public function findByEmployee()
    {
        $user = Auth::user();
        if (!$user) {
            return $this->error($user, 'User not found', 404);
        }
        if (!$user) {
            return $this->error(null, 'User not found', 404);
        }
        $riads = Riad::where('id', $user->riad_id)->with('images')->get();
        if ($riads->isEmpty()) {
            return $this->error(null, 'No riads found for this user', 404);
        }
        return $this->success(['riads' => $riads], 'Riads retrieved successfully', 200);
    }

    public static function riad($slug)
    {
        return Riad::where('slug', $slug);
    }
}
