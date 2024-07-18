<?php

namespace App\Http\Controllers\Api\V1\RentalCar;

use App\Http\Controllers\Controller;
use App\Http\Trait\ApiTrait;
use App\Models\RentalCarFavorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RentalCarFavoriteController extends Controller
{
    use ApiTrait;

    public function index()
    {
        $user_id = Auth::guard('api')->user()->id;
        $favorites = RentalCarFavorite::with('rentalCars','user')->where('user_id',$user_id)->get();
        return $this->response($favorites,'success',200);
    }
    public function addToFavorites(Request $request)
    {
        $request->validate([
            'rental_car_id' => ['required','exists:rental_cars,id'],
        ]);

        $favorite = RentalCarFavorite::updateOrCreate([
            'user_id' => Auth::guard('api')->user()->id,
            'rental_car_id' => $request->rental_car_id,
        ]);
        $favorite->is_favorite = 1;

        return $this->response($favorite,'The car has been added to favorites',201);
    }

    public function removeFromFavorites(Request $request)
    {
        $request->validate([
            'rental_car_id' => 'required',
        ]);

        $favorite = RentalCarFavorite::where('user_id', Auth::guard('api')->user()->id)
            ->where('rental_car_id', $request->rental_car_id)->first();

        if ($favorite) {
            $favorite->delete();
            return $this->response(['is_favorite' => 0,'rental_car_id'=>$request->rental_car_id],'The car has been removed from favorites.',200);
        }


        return $this->response('','Favorite not found.',404);
    }

}
