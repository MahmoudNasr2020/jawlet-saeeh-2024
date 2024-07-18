<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentalCarReservation extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'phone_number', 'identity_number', 'license_number', 'start_datetime',
                            'end_datetime', 'latitude', 'longitude', 'total_price',
                                'user_id','rental_car_id','city_id','contract_status','status','is_viewed'];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function rentalCar()
    {
        return $this->belongsTo(RentalCar::class,'rental_car_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class,'city_id');
    }

}
