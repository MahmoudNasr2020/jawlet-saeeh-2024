<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TouristGuide extends Model
{
    use HasFactory;

    protected $fillable = ['name','email','image', 'phone'];

    public function places()
    {
        return $this->belongsToMany(TouristGuidePlace::class, 'tourist_guide_place');
    }

    public function getImageAttribute($value)
    {
        return asset('images/' . $value);
    }
}
