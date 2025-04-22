<?php

namespace App\Models;

use Spatie\Sluggable\SlugOptions;
use Spatie\Sluggable\HasSlug;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Entreprise extends Model
{
    use HasFactory, HasSlug;

    protected $fillable = [
        'name',
        'owner',
        'email',
        'phone',
        'address',
        'status',
        'description',
        'logo',
        'documents',
        'riadsCount',
        'employeesCount',
        'user_id'
    ];

    protected $casts = [
        'documents' => 'array',
        'riadsCount' => 'integer',
        'employeesCount' => 'integer',
        'createdAt' => 'datetime'
    ];

    public function services()
    {
        return $this->hasMany(Service::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function employes()
    {
        return $this->hasOne(User::class);
    }

    public function riad()
    {
        return $this->hasMany(Riad::class);
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name') // Génère le slug à partir du nom
            ->saveSlugsTo('slug')
            ->slugsShouldBeNoLongerThan(50); // Limite la longueur du slug à 50 caractères
    }
}
