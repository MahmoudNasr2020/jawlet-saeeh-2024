<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Http\Controllers\Controller;
use App\Http\Trait\ApiTrait;
use App\Models\FlightReservation;
use App\Models\HotelFavorite;
use App\Models\HotelReservation;
use App\Models\RentalCarFavorite;
use App\Models\RentalCarReservation;
use App\Models\RestaurantReservation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    use ApiTrait;
    public function hotelReservations()
    {
        $user = Auth::user();
        $now = Carbon::now();

        $hotelReservations = HotelReservation::where('user_id', $user->id)
            ->with('hotel')
            ->get()
            ->map(function ($reservation) use ($now) {
                // تحديد حالة الحجز بناءً على الشروط
                if ($reservation->is_canceled == 1) {
                    $reservationStatus = 'Canceled';
                } elseif ($reservation->is_canceled == 0 && $reservation->status == 0) {
                    $reservationStatus = 'Waiting';
                } elseif ($reservation->is_canceled == 0 && $reservation->status == 1) {
                    if ($reservation->start_datetime > $now) {
                        $reservationStatus = 'Upcoming';
                    } elseif ($reservation->end_datetime < $now) {
                        $reservationStatus = 'Expired';
                    } else {
                        $reservationStatus = 'Current';
                    }
                }

                return [
                    'id' => $reservation->id,
                    'hotel_name' => $reservation->hotel->name,
                    'room_type' => optional($reservation->getRoom())->type,
                    'total_price' => $reservation->total_price,
                    'hotel_image' => $reservation->hotel->main_image,
                    'start_datetime' => $reservation->start_datetime,
                    'end_datetime' => $reservation->end_datetime,
                    'reservation_status' => $reservationStatus,
                ];
            });

        return $this->response(['hotel_reservations' => $hotelReservations],'',200);
    }

    public function carReservations()
    {
        $user = Auth::user();
        $now = Carbon::now();

        $carReservations = RentalCarReservation::where('user_id', $user->id)
            ->with('rentalCar')
            ->get()
            ->map(function ($reservation) use ($now) {
                if ($reservation->status == 0) {
                    $reservationStatus = 'Waiting';
                } elseif ($reservation->status == 1) {
                    if ($reservation->start_datetime > $now) {
                        $reservationStatus = 'Upcoming';
                    } elseif ($reservation->end_datetime < $now) {
                        $reservationStatus = 'Expired';
                    } else {
                        $reservationStatus = 'Current';
                    }
                }

                return [
                    'id' => $reservation->id,
                    'car_name' => $reservation->rentalCar->name,
                    'car_image' => $reservation->rentalCar->main_image,
                    'total_price' => $reservation->total_price,
                    'start_datetime' => $reservation->start_datetime,
                    'end_datetime' => $reservation->end_datetime,
                    'reservation_status' => $reservationStatus,
                ];
            });

        //return response()->json(['car_reservations' => $carReservations], 200);
        return $this->response(['car_reservations' => $carReservations],'',200);
    }

    public function restaurantReservations()
    {
        $user = Auth::guard('api')->user();
        $now = Carbon::now();

         $restaurantReservations = RestaurantReservation::where('user_id', $user->id)
            ->with('restaurant')
            ->get()
            ->map(function ($reservation) use ($now,$user) {
                // تحديد حالة الحجز بناءً على الشروط
                if ($reservation->is_canceled == 1) {
                    $reservationStatus = 'Canceled';
                } elseif ($reservation->is_canceled == 0 && $reservation->status == 0) {
                    $reservationStatus = 'Waiting';
                } elseif ($reservation->is_canceled == 0 && $reservation->status == 1) {
                    if ($reservation->booking_date > $now) {
                        $reservationStatus = 'Upcoming';
                    } elseif ($reservation->booking_date < $now) {
                        $reservationStatus = 'Expired';
                    } else {
                        $reservationStatus = 'Current';
                    }
                }

                // تنسيق بيانات المطعم مع الأنواع المطلوبة
                $restaurant = $reservation->restaurant;
                return [
                    'id' => $reservation->id,
                    'restaurant_id' => $restaurant->id,
                    'restaurant_name' => $restaurant->name,
                    'restaurant_image' => $restaurant->main_image,
                    'rating' => $restaurant->averageRating() ? round($restaurant->averageRating(), 1) : null,
                    'is_Fav' => $restaurant->favorites()->where('user_id', $user->id)->exists() ? 1 : 0,
                    'total_price' => (double) $reservation->total_price,
                    'latitude' => (double) $restaurant->latitude,
                    'longitude' => (double) $restaurant->longitude,
                    'reservation_status' => $reservationStatus,

                ];
            });

        return $this->response(['restaurant_reservations' => $restaurantReservations],'',200);
        //return response()->json(['restaurant_reservations' => $restaurantReservations], 200);
    }


    public function flightReservations()
    {
        $user = Auth::user();

        $flightReservations = FlightReservation::where('user_id', $user->id)
            ->with(['fromAirport', 'toAirport'])
            ->get()
            ->map(function ($reservation) {
                // تحديد حالة الحجز بناءً على status و is_canceled
                if ($reservation->status == 1 && $reservation->is_canceled == 0) {
                    $reservationStatus = 'Active';
                }
                elseif ($reservation->status == 0 && $reservation->is_canceled == 0) {
                    $reservationStatus = 'Waiting';
                }
                else
                {
                    $reservationStatus = 'Canceled';
                }

                return [
                    'id' => $reservation->id,
                    'type' => $reservation->type,
                    'from_airport' => $reservation->fromAirport->name_ar,
                    'to_airport' => $reservation->toAirport->name_ar,
                    'start_datetime' => $reservation->start_datetime,
                    'end_datetime' => $reservation->end_datetime,
                    'number_of_persons' => $reservation->number_of_persons,
                    'class' => $reservation->class,
                    'reservation_status' => $reservationStatus,
                ];
            });

        return $this->response(['flight_reservations' => $flightReservations],'',200);
    }


}
