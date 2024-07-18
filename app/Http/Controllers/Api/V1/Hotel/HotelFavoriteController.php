<?php

namespace App\Http\Controllers\Api\V1\Hotel;

use App\Http\Controllers\Controller;
use App\Http\Trait\ApiTrait;
use App\Models\HotelFavorite;
use App\Models\RentalCarFavorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HotelFavoriteController extends Controller
{
    use ApiTrait;

    public function index()
    {
        $user_id = Auth::guard('api')->user()->id;
        $favorites = HotelFavorite::with('hotel:id,name,main_image,location,price_per_day','user:id,first_name,last_name,email,phone,image')->where('user_id',$user_id)->get();
        return $this->response($favorites,'success',200);
    }
    public function addToFavorites(Request $request)
    {
        $request->validate([
            'hotel_id' => ['required','exists:hotels,id'],
        ]);

        $favorite = HotelFavorite::updateOrCreate([
            'user_id' => Auth::guard('api')->user()->id,
            'hotel_id' => $request->hotel_id,
        ]);
        $favorite->is_favorite = 1;

        return $this->response($favorite,'The hotel has been added to favorites',201);
    }

    public function removeFromFavorites(Request $request)
    {
        $request->validate([
            'hotel_id' => 'required',
        ]);

        $favorite = HotelFavorite::where('user_id', Auth::guard('api')->user()->id)
            ->where('hotel_id', $request->hotel_id)->first();

        if ($favorite) {
            $favorite->delete();
            return $this->response(['is_favorite' => 0,'hotel_id'=>$request->hotel_id],'The hotel has been removed from favorites.',200);
        }


        return $this->response('','Favorite not found.',404);
    }
}
