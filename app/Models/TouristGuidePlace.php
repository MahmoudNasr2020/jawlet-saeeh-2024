<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TouristGuidePlace extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function guides()
    {
        return $this->belongsToMany(TouristGuide::class, 'tourist_guide_place');
    }
}
