<?php

namespace App\Http\Controllers\Api\V1\Home;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use App\Models\RentalCar;
use App\Models\Restaurant;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // جلب الفنادق الأكثر حجزاً مع التقييم وعدد الحجوزات
        $mostBookedHotels = Hotel::withCount('reservations')
            ->having('reservations_count', '>', 0)
            ->with('ratings')
            ->orderBy('reservations_count', 'desc')
            ->take(5)
            ->get()
            ->map(function ($hotel) {
                return [
                    'id' => $hotel->id,
                    'name' => $hotel->name,
                    'price_per_day' => $hotel->price_per_day,
                    'main_image' => $hotel->main_image,
                    'rating' =>  (float) $hotel->averageRating() != null ? $hotel->averageRating() : 0 ,
                    'reservations_count' => $hotel->reservations_count,
                ];
            });

        // جلب السيارات الأكثر حجزاً مع التقييم وعدد الحجوزات
        $mostBookedCars = RentalCar::withCount('reservations')
            ->having('reservations_count', '>', 0)
            ->with('ratings')
            ->orderBy('reservations_count', 'desc')
            ->take(5)
            ->get()
            ->map(function ($car) {
                return [
                    'id' => $car->id,
                    'name' => $car->name,
                    'price_per_day' => $car->price_per_day,
                    'main_image' => $car->main_image,
                     'rating' => (float) $car->averageRating(),
                    'reservations_count' => $car->reservations_count,
                ];
            });

        // جلب المطاعم الأكثر حجزاً مع الحقول المحددة وعدد الحجوزات
        $mostBookedRestaurants = Restaurant::withCount('reservations')
            ->having('reservations_count', '>', 0)
            ->orderBy('reservations_count', 'desc')
            ->take(5)
            ->get(['id', 'name', 'prise'])
            ->map(function ($restaurant) {
                return [
                    'id' => $restaurant->id,
                    'name' => $restaurant->name,
                    'price' => $restaurant->prise,
                  'rating' =>  (float) $restaurant->averageRating(),
                    'reservations_count' => $restaurant->reservations_count,
                ];
            });

        return response()->json([
            'most_booked_hotels' => $mostBookedHotels,
            'most_booked_cars' => $mostBookedCars,
            'most_booked_restaurants' => $mostBookedRestaurants,
        ], 200);
    }
}
