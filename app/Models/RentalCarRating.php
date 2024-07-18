<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentalCarRating extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','rental_car_id','rating'];

    public function rentalCar()
    {
        return $this->belongsTo(RentalCar::class,'rental_car_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }



}
