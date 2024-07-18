<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory;

    protected $fillable = ['name','main_image','images','location', 'price_per_day',
        'description','public_utility','latitude', 'longitude','service_fees'];

    public function getMainImageAttribute($value)
    {
        return asset('images/' . $value);
    }

    public function getImagesAttribute($value)
    {
        if ($value != '')
        {
            $imagePaths = json_decode($value, true);
            $fullPaths = [];

            foreach ($imagePaths as $imagePath) {
                $fullPaths[] = asset('images/'.$imagePath);
            }

            return $fullPaths;
        }

    }

    public function getPublicUtilityAttribute($value)
    {
        if ($value != '')
        {
            $data = json_decode($value, true);
            $fullPaths = [];

            foreach ($data as $item) {
                $fullPaths[] = [
                    'name' => isset($item['name']) ? $item['name'] : '' ,
                    'image' => isset($item['image']) ? asset('images/'.$item['image']) : '',
                ];
            }

            return $fullPaths;
        }

    }


    public function ratings()
    {
        return $this->hasMany(HotelRating::class);
    }

    public function averageRating()
    {
        return $this->ratings()->average('rating');
    }

    public function rooms()
    {
        return $this->hasMany(Room::class,'hotel_id');
    }

    public function reservations()
    {
        return $this->hasMany(HotelReservation::class,'hotel_id');
    }

}
