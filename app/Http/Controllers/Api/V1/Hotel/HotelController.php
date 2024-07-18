<?php

namespace App\Http\Controllers\Api\V1\Hotel;

use App\Http\Controllers\Controller;
use App\Http\Trait\ApiTrait;
use App\Models\City;
use App\Models\Hotel;
use App\Models\HotelFavorite;
use App\Models\RentalCarFavorite;
use App\Models\Room;
use Illuminate\Support\Facades\Auth;

class HotelController extends Controller
{
    use ApiTrait;
    public function index()
    {
        $hotels = Hotel::select('id','name','main_image')->get();
        return $this->response(['hotels' => $hotels],'',200);
    }


    public function show($hotel_id)
    {
        $hotel = Hotel::select('id','name','main_image','images','description','price_per_day','service_fees','location')->find($hotel_id);
        if(!$hotel)
        {
            return $this->response('','This Hotel does not exist',404);
        }
       if (Auth::guard('api')->check()) {
            $favorite = HotelFavorite::where('user_id',Auth::guard('api')->user()->id)
                ->where('hotel_id',$hotel_id)->first();

            $hotel->is_favorite = $favorite ? 1 : 0;
        }

        $hotel->rating = (int) $hotel->averageRating();

        return $this->response([
            'hotel' => $hotel,
            // 'rental_cars_department'=> $car_department->rentalCars
        ],'',200);
    }


    public function show_more($hotel_id)
    {
        $hotel = Hotel::with(['ratings'=>function ($q){
            $q->orderBy('rating','desc')->limit(5)->with('user:id,first_name,last_name,image');
        }])->find($hotel_id);

        if(!$hotel)
        {
            return $this->response('','This Hotel does not exist',404);
        }

        if (Auth::guard('api')->check()) {
            $favorite = HotelFavorite::where('user_id',Auth::guard('api')->user()->id)
                ->where('hotel_id',$hotel_id)->first();

            $hotel->is_favorite = $favorite ? 1 : 0;
        }

        $hotel->rating = (int) $hotel->averageRating();

        return $this->response([
            'hotel' => $hotel,
            // 'rental_cars_department'=> $car_department->rentalCars
        ],'',200);
    }




    public function hotels_most_wanted()
    {
        $mostWantedHotels = Hotel::select('id', 'name', 'main_image')
            ->withCount('reservations')
            ->whereHas('reservations')
            ->orderBy('reservations_count', 'desc')
            ->limit(6)->get()->map(function ($hotel) {
                $hotel->rating = (int) $hotel->averageRating();
                return $hotel;
            });


        return $this->response($mostWantedHotels,'',200);
    }

    public function get_rooms($hotel_id)
    {
        $rooms = Room::where('hotel_id',$hotel_id)->select('id','type','hotel_id','price_per_day')
            //->with('hotel:id,name')
            ->get();
        return $this->response($rooms,'',200);
    }
}
