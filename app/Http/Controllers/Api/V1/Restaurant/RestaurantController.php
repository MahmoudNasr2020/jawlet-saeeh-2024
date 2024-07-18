<?php

namespace App\Http\Controllers\Api\V1\Restaurant;

use App\Models\Restaurant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\RestaurantResource;
use \Illuminate\Http\JsonResponse;
use App\Http\Trait\ApiTrait;
use Illuminate\Support\Facades\Auth;

class RestaurantController extends Controller
{
  
  use ApiTrait;
  
   public function index(Request $request)
    {
        $latitude = (double) $request->input('latitude');
        $longitude = (double) $request->input('longitude');
        $radius = (double) $request->input('radius', 10.0); // يمكنك تحديد النطاق الافتراضي بالكيلومترات

        if (!$latitude || !$longitude) {
            return $this->response(null, 'Latitude and Longitude are required', 400);
        }

        if (!is_numeric($latitude) || !is_numeric($longitude)) {
            return $this->response(null, 'Invalid Latitude or Longitude', 400);
        }

        $userId = Auth::guard('api')->user() ? Auth::guard('api')->user()->id : null;

        $restaurants = Restaurant::selectRaw("
            id, name, CAST(longitude AS DOUBLE) as longitude, CAST(latitude AS DOUBLE) as latitude,
            main_image as image, `desc` as description, price,
            (SELECT AVG(rating) FROM restaurant_ratings WHERE restaurant_ratings.restaurant_id = restaurants.id) as rating, location as address,
            (6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)))) AS distance_km",
            [$latitude, $longitude, $latitude])
            ->having("distance_km", "<", $radius)
            ->orderBy("distance_km")
            ->get()
            ->map(function($restaurant) use ($userId) {
                $restaurant->distance_m = (int) ($restaurant->distance_km * 1000); // تحويل المسافة من كيلومترات إلى أمتار
                $restaurant->image = asset('images/'.$restaurant->image);
                $restaurant->rating = $restaurant->rating ? round($restaurant->rating, 1) : null;
                $restaurant->price = (float) $restaurant->price;
                $restaurant->address = (string) $restaurant->address;
                $restaurant->id = (int) $restaurant->id;

                $result = [
                    'id' => $restaurant->id,
                    'name' => $restaurant->name,
                    'longitude' => $restaurant->longitude,
                    'latitude' => $restaurant->latitude,
                    'image' => $restaurant->image,
                    'description' => $restaurant->description,
                    'price' => $restaurant->price,
                    'rating' => $restaurant->rating,
                    'address' => $restaurant->address,
                    'distance_m' => $restaurant->distance_m,
                    'distance_km' => $restaurant->distance_km,
                ];

                // إضافة is_fav إذا كان المستخدم مسجل الدخول
                if ($userId) {
                    $result['is_fav'] = $restaurant->favorites()->where('user_id', $userId)->exists() ? 1 : 0;
                }

                return $result;
            });

        return $this->response([
            'restaurants' => $restaurants
        ], 'Restaurants fetched successfully', 200);
    }



     public function show($id)
    {
        $restaurant = Restaurant::find($id);

        if (!$restaurant) {
            return $this->response(null, 'This Restaurant does not exist', 404);
        }

        $averageRating = round($restaurant->averageRating(), 2);
        $price = (float) $restaurant->price;

        return $this->response([
            'restaurant' => [
                'id' => $restaurant->id,
                'name' => $restaurant->name,
                'description' => $restaurant->desc,
                'price' => $price,
                'rating' => $averageRating,
                'service_fees' => $restaurant->service_fees,
                'address' => $restaurant->location,
                'longitude' => $restaurant->longitude,
                'latitude' => $restaurant->latitude,
                'image' => $restaurant->main_image,
                'created_at' => $restaurant->created_at,
                'updated_at' => $restaurant->updated_at,
            ]
        ], 'Restaurant fetched successfully', 200);
    }
}
