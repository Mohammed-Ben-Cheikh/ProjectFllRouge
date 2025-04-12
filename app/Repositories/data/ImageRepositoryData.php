<?php

namespace App\Repositories\data;

use App\Models\RiadImages;
use App\Models\ChambreImages;
use App\Models\ServiceImages;
use App\Models\VilleImages;
use App\Traits\HttpResponses;
use App\Repositories\Contracts\ImageRepository;
use Illuminate\Support\Facades\Storage;

class ImageRepositoryData implements ImageRepository
{
    use HttpResponses;

    public function all()
    {
        $riadImages = RiadImages::all();
        $chambreImages = ChambreImages::all();
        $serviceImages = ServiceImages::all();
        $villeImages = VilleImages::all();
        return collect([$riadImages, $chambreImages, $serviceImages, $villeImages])->flatten();
    }

    public function findBySlug(string $slug)
    {
        foreach(['RiadImages', 'ChambreImages', 'ServiceImages', 'VilleImages'] as $model) {
            $modelClass = "App\\Models\\{$model}";
            $image = $modelClass::where('slug', $slug)->first();
            if ($image) return $image;
        }
        return null;
    }

    public function create(array $data)
    {
        switch($data['type']) {
            case 'riad':
                return RiadImages::create($data);
            case 'chambre':
                return ChambreImages::create($data);
            case 'service':
                return ServiceImages::create($data);
            case 'ville':
                return VilleImages::create($data);
            default:
                return $this->error('Invalid image type', 400);
        }
    }

    public function update($image, array $data)
    {
        if (isset($data['image']) && $image->image_path) {
            Storage::delete($image->image_path);
        }
        $image->update($data);
        return $image;
    }

    public function delete(string $slug)
    {
        $image = $this->findBySlug($slug);
        if (!$image) {
            return $this->error('Image not found', 404);
        }
        if ($image->image_path) {
            Storage::delete($image->image_path);
        }
        $image->delete();
        return $this->success('Image deleted successfully', 200);
    }

    public function findByModel(string $model, string $modelId)
    {
        $modelClass = "App\\Models\\{$model}Images";
        if (!class_exists($modelClass)) {
            return $this->error('Invalid model type', 400);
        }

        $images = $modelClass::where("{$model}_id", $modelId)->get();
        if ($images->isEmpty()) {
            return $this->error("No images found for this {$model}", 404);
        }
        return $images;
    }

    public function storeImage($file, string $path)
    {
        try {
            $filename = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs($path, $filename, 'public');
            return $filePath;
        } catch (\Exception $e) {
            return $this->error('Failed to store image', 500);
        }
    }
}
