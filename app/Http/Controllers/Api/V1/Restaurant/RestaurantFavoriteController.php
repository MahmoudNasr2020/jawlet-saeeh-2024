<?php

namespace App\Http\Controllers\Api\V1\Restaurant;

use App\Http\Controllers\Controller;
use App\Http\Trait\ApiTrait;
use App\Models\RestaurantFavorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RestaurantFavoriteController extends Controller
{
    use ApiTrait;


    public function index()
    {
        $userId = Auth::guard('api')->user()->id;
        $favorites = RestaurantFavorite::where('user_id', $userId)
            ->with(['restaurant' => function($query) {
                $query->select('id', 'name', 'price', 'main_image', 'latitude', 'longitude');
            }])
            ->get()
            ->map(function($favorite) {
                return [
                    'id' => (int) $favorite->restaurant->id,
                    'name' => (string) $favorite->restaurant->name,
                    'price' => (double) $favorite->restaurant->price,
                    'image' => asset('images/' . $favorite->restaurant->main_image),
                    'latitude' => (double) $favorite->restaurant->latitude,
                    'longitude' => (double) $favorite->restaurant->longitude,
                ];
            });

        return $this->response($favorites, 'Favorites fetched successfully', 200);
    }

    public function addToFavorites(Request $request)
    {
        // التحقق من الإدخالات
       /* $validator = Validator::make($request->all(), [
            'restaurant_id' => 'required|exists:restaurants,id',
        ]);*/

        $request->validate([
            'restaurant_id' => 'required|exists:restaurants,id',
        ]);
        /*if ($validator->fails()) {
            return $this->response(['errors' => $validator->errors()], 'Validation Error', 422);
        }*/

        $userId = Auth::guard('api')->user()->id;
        $restaurantId = $request->input('restaurant_id');

        // تحقق مما إذا كانت المفضلة موجودة بالفعل
        $existingFavorite = RestaurantFavorite::where('user_id', $userId)
            ->where('restaurant_id', $restaurantId)
            ->first();

        if ($existingFavorite) {
            return $this->response(null, 'Restaurant is already in favorites', 409);
        }

        $favorite = RestaurantFavorite::create([
            'user_id' => $userId,
            'restaurant_id' => $restaurantId
        ]);

        $favorite->is_favorite = 1;

        return $this->response($favorite, 'Restaurant added to favorites', 201);
    }

    public function removeFromFavorites(Request $request)
    {
        /*$validator = Validator::make($request->all(), [
            'restaurant_id' => 'required|exists:restaurants,id',
        ]);

        if ($validator->fails()) {
            return $this->response(null, 'Validation Error', 422);
        }*/

        $request->validate([
            'restaurant_id' => 'required|exists:restaurants,id',
        ]);

        $userId = Auth::guard('api')->user()->id;
        $restaurantId = $request->input('restaurant_id');

        $favorite = RestaurantFavorite::where('user_id', $userId)
            ->where('restaurant_id', $restaurantId)
            ->first();

        if ($favorite) {
            $favorite->delete();
            return $this->response(['is_favorite' => 0,'restaurant_id'=>(int) $request->restaurant_id], 'Restaurant removed from favorites', 200);
        } else {
            return $this->response(null, 'Favorite not found', 404);
        }
    }
}
