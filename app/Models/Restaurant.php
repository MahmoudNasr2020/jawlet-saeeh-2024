<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Restaurant extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

     protected $fillable = [
        'name',
        'desc',
        'price',
        'rating',
        'service_fees',
        'location',
        'latitude',
        'longitude',
        'main_image'
    ];

    public function reservations()
    {
        return $this->hasMany(RestaurantReservation::class,'restaurant_id');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('default');
    }

    public function getMainImageAttribute($value)
    {
        return asset('images/' . $value);
    }

  
   public function ratings()
    {
        return $this->hasMany(RestaurantRating::class);
    }

    public function averageRating()
    {
        return $this->ratings()->average('rating');
    }

    public function favorites()
    {
        return $this->hasMany(RestaurantFavorite::class);
    }
}
