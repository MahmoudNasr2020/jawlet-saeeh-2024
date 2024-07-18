<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentalCarDepartments extends Model
{
    use HasFactory;
    protected $fillable = ['name','image'];

    public function rentalCars()
    {
        return $this->hasMany(RentalCar::class,'rental_car_department_id');
    }

    public function getImageAttribute($value)
    {
        return asset('images/' . $value);
    }

}
