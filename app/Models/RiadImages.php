<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiadImages extends Model
{
    use HasFactory;

    protected $fillable = [
        'riad_id',
        'image_path'
    ];

    public function riad()
    {
        return $this->belongsTo(Riad::class);
    }
}
