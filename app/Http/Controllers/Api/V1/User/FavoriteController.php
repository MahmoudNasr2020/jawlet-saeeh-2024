<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Http\Controllers\Controller;
use App\Models\HotelFavorite;
use App\Models\RentalCarFavorite;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function favorites(Request $request)
    {
        $type = $request->query('type');

        if ($type === 'hotels') {
            $favorites = HotelFavorite::with('hotel')
                ->get()
                ->map(function ($favorite) {
                    return [
                        'id' => $favorite->hotel->id,
                        'name' => $favorite->hotel->name,
                        'price_per_day' => $favorite->hotel->price_per_day,
                        'location' => $favorite->hotel->location,
                        'main_image' => $favorite->hotel->main_image,
                        'average_rating' => $favorite->hotel->ratings()->average('rating'),
                    ];
                });

            return response()->json(['favorite_hotels' => $favorites], 200);
        }
        elseif ($type === 'cars') {
            $favorites = RentalCarFavorite::with('rentalCars')
                ->get()
                ->map(function ($favorite) {
                    return [
                        'id' => $favorite->rentalCars->id,
                        'name' => $favorite->rentalCars->name,
                        'price_per_day' => $favorite->rentalCars->price_per_day,
                        'location' => $favorite->rentalCars->location,
                        'main_image' => $favorite->rentalCars->main_image,
                        'average_rating' => $favorite->rentalCars->ratings()->average('rating'),
                    ];
                });

            return response()->json(['favorite_cars' => $favorites], 200);
        }

        else
        {
            $favoriteHotels = HotelFavorite::with('hotel')
                ->get()
                ->map(function ($favorite) {
                    return [
                        'id' => $favorite->hotel->id,
                        'name' => $favorite->hotel->name,
                        'price_per_day' => $favorite->hotel->price_per_day,
                        'location' => $favorite->hotel->location,
                        'main_image' => $favorite->hotel->main_image,
                        'average_rating' => $favorite->hotel->ratings()->average('rating'),
                    ];
                });

            $favoriteCars = RentalCarFavorite::with('rentalCars')
                ->get()
                ->map(function ($favorite) {
                    return [
                        'id' => $favorite->rentalCars->id,
                        'name' => $favorite->rentalCars->name,
                        'price_per_day' => $favorite->rentalCars->price_per_day,
                        'location' => $favorite->rentalCars->location,
                        'main_image' => $favorite->rentalCars->main_image,
                        'average_rating' => $favorite->rentalCars->ratings()->average('rating'),
                    ];
                });

            return response()->json([
                'favorite_hotels' => $favoriteHotels,
                'favorite_cars' => $favoriteCars,
            ], 200);
        }
    }
}
