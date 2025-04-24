<?php

namespace App\Repositories\data;

use App\Models\Entreprise;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Validator;
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
        $entreprise = static::entreprise($slug)->first();
        if ($entreprise->destroy) {
            return $this->error(null, 'Entreprise is deleted', 404);
        }
        return $this->success(['entreprise' => static::entreprise($slug)->first()], 'Entreprise found successfully', 200);
    }

    public function create(array $data)
    {

        $data['user_id'] = Auth::id();
        // dd($data);
        $data['logo'] = $data['logo']->store('entreprises', 'public');
        if ($entreprise = Entreprise::create($data)) {
            return $this->success(['entreprise' => $entreprise], 'Entreprise created successfully', 200);
        } else
            return $this->error(null, 'Failed to create entreprise');
    }

    public function update($slug, array $data)
    {
        $entreprise = static::entreprise($slug)->first();

        if (isset($data['logo'])) {
            // Delete old logo
            if ($entreprise->logo) {
                $oldImagePath = public_path("storage/{$entreprise->logo}");
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
            // Store new logo
            $data['logo'] = $data['logo']->store('entreprises', 'public');
        }
        if ($entreprise->update($data)) {
            return $this->success(['entreprise' => $entreprise], 'Entreprise updated successfully', 200);
        } else {
            return $this->error(null, 'Failed to update entreprise');
        }
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
            $query->where('id', $id)->where('destroy', '=', false);
        })->get();

        if ($entreprises->isEmpty()) {
            return $this->error(null, 'No entreprises found for this user', 404);
        }
        return $this->success(['entreprises' => $entreprises], 'Entreprises retrieved successfully', 200);
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
        $entreprise = static::entreprise($slug)->first();
        if (!$entreprise) {
            return $this->error(null, 'Entreprise not found', 404);
        }
        if ($entreprise->update($data)) {
            return $this->success(['entreprise' => $entreprise], 'Entreprise status updated successfully', 200);
        } else {
            return $this->error(null, 'Failed to update entreprise status');
        }
    }

    public static function entreprise($slug)
    {
        return Entreprise::where('slug', $slug);
    }
}
