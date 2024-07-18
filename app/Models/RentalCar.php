<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentalCar extends Model
{
    use HasFactory;
    protected $fillable = ['name','main_image','images','location','rental_car_department_id','count','price_per_day','description'];

    public function rentalCarDepartment()
    {
        return $this->belongsTo(RentalCarDepartments::class,'rental_car_department_id');
    }

    public function reservations()
    {
        return $this->hasMany(RentalCarReservation::class,'rental_car_id');
    }

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

    public function ratings()
    {
        return $this->hasMany(RentalCarRating::class);
    }

    public function averageRating()
    {
        return $this->ratings()->average('rating');
    }

}
