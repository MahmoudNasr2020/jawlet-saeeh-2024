<?php

namespace App\Http\Controllers\Api\V1\RentalCar;

use App\Http\Controllers\Controller;
use App\Http\Trait\ApiTrait;
use App\Models\City;
use App\Models\RentalCar;
use App\Models\RentalCarDepartments;
use App\Models\RentalCarFavorite;
use Illuminate\Support\Facades\Auth;

class RentalCarController extends Controller
{
    use ApiTrait;
    public function cars_departments()
    {
        $car_departments = RentalCarDepartments::get();
        return $this->response(['car_departments' => $car_departments],'',200);
    }



    public function car_department_show($car_department_id)
    {
        $user_id = auth()->guard('api')->id();

        $car_department = RentalCarDepartments::with(['rentalCars'=> function ($q){
            $q->select('id','name','price_per_day','location','rental_car_department_id','main_image');
        }])->find($car_department_id);

         $car_department->rentalCars->map(function ($car){
            $car->rating = (int) $car->averageRating();
        });

        if (!$car_department) {
            return $this->response('', 'This department does not exist', 404);
        }

        if(Auth::guard('api')->check())
        {
            $favorites = RentalCarFavorite::where('user_id', $user_id)
                ->pluck('rental_car_id')->toArray();

            $car_department->rentalCars = $car_department->rentalCars->map(function ($car) use ($favorites) {
                $car->is_favorite = in_array($car->id, $favorites) ? 1 : 0;
                return $car;
            });
        }

        return $this->response([
            'department' => $car_department,
        ], '', 200);

    }

    public function rental_car_show($rental_car_id)
    {
        $car = RentalCar::find($rental_car_id);
        if(!$car)
        {
            return $this->response('','This Rental Car does not exist',404);
        }
        if (Auth::guard('api')->check()) {
            $favorite = RentalCarFavorite::where('user_id',Auth::guard('api')->user()->id)
                ->where('rental_car_id',$rental_car_id)->first();

            $car->is_favorite = $favorite ? 1 : 0;
        }

        $car->rating = (int) $car->averageRating();

        return $this->response([
            'rental_car' => $car,
            // 'rental_cars_department'=> $car_department->rentalCars
        ],'',200);
    }


    public function rental_car_cities()
    {
        $cities = City::get();
        return $this->response($cities,'',200);
    }


    public function rental_car_most_wanted()
    {
        $mostWantedCars = RentalCar::select('id', 'name', 'main_image','images','price_per_day','location')
            ->withCount('reservations')
            ->whereHas('reservations')
            ->orderBy('reservations_count', 'desc')
            ->limit(6)->get()->map(function ($car) {
                $car->rating = (int) $car->averageRating();
                return $car;
            });


        return $this->response($mostWantedCars,'',200);
    }

}
