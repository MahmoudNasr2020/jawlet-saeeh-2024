<?php

namespace App\Http\Controllers\Api\V1\Hotel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\HotelReservationRequest;
use App\Http\Trait\ApiTrait;
use App\Models\Hotel;
use App\Models\HotelCoupon;
use App\Models\HotelReservation;
use App\Models\RentalCar;
use App\Models\RentalCarReservation;
use App\Models\Room;
use App\Services\MoyasarService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;


class HotelReservationController extends Controller
{
    use ApiTrait;

    public $moyasarService;
    public function __construct(MoyasarService $moyasarService)
    {
        $this->moyasarService = $moyasarService;
    }

    /*public function store_reservation(HotelReservationRequest $request)
    {
        return DB::transaction(function () use ($request) {

            $startDatetime = Carbon::parse($request->start_date);
            $endDatetime = Carbon::parse($request->end_date);

            $roomIds = json_decode($request->rooms);
            $numberOfNights = $startDatetime->diffInDays($endDatetime);

            $roomsRequested = Room::whereIn('id', $roomIds)->get();

            if ($roomsRequested->count() < count($roomIds)) {
                return $this->response('', 'One or more rooms not found.', 422);
            }

            $totalPrice = 0;

            foreach ($roomsRequested as $room) {
                $reservationsForRoom = HotelReservation::where('end_datetime', '>', $startDatetime)
                    ->where('start_datetime', '<', $endDatetime)
                    ->whereJsonContains('rooms', $room->id)
                    ->count();

                if ($reservationsForRoom >= $room->count) {
                    return $this->response('', 'Rooms of type ' . $room->type . ' are fully booked in the requested period.', 422);
                }

                 $totalPrice += $room->price_per_day * $numberOfNights;
            }


            $reservationData = [
                'hotel_id' => $request->hotel_id,
                'user_id' => Auth::guard('api')->user()->id,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'email' => $request->email,
                'number_of_persons' => json_encode($request->number_of_persons),
                'rooms' => json_encode($roomIds),
                'total_price' => $totalPrice
            ];

            $card_data = [
                'card_customer_name' => $request->card_customer_name,
                'card_number' => $request->card_number,
                'card_cvc' => $request->card_cvc,
                'card_month' =>$request->card_month,
                'card_year' =>$request->card_year,
            ];
            $payment =  $this->moyasarService->makePayment($card_data,$reservationData);

            return $this->response(['payment_url' => $payment], '', 200);
        });
    }*/


    /*public function store_reservation(HotelReservationRequest $request)
    {
        return DB::transaction(function () use ($request) {
            // Parse dates
            $startDatetime = Carbon::parse($request->start_date);
            $endDatetime = Carbon::parse($request->end_date);

            // Retrieve room information
            $roomIds = $request->room;
            $numberOfNights = $startDatetime->diffInDays($endDatetime);
            $roomsRequested = Room::where('id', $roomIds)->first();

            if (!$roomsRequested) {
                return $this->response('', 'Room not found.', 422);
            }

            $totalPrice = 0;
            $reservationsForRoom = HotelReservation::where('end_datetime', '>', $startDatetime)
                ->where('start_datetime', '<', $endDatetime)
                ->whereJsonContains('rooms', $roomsRequested->id)
                ->count();

            if ($reservationsForRoom >= $roomsRequested->count) {
                return $this->response('', 'Rooms of type ' . $roomsRequested->type . ' are fully booked in the requested period.', 422);
            }

            // Calculate total price
            $totalPrice += $roomsRequested->price_per_day * $numberOfNights;

            // Prepare reservation data
            $reservationData = [
                'hotel_id' => $request->hotel_id,
                'user_id' => Auth::guard('api')->user()->id,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'email' => $request->email,
                'adults' => $request->adults,
                'children' => $request->children,
                'rooms' => $roomIds,
                'total_price' => $totalPrice
            ];

            // Encrypt and create payment URL
            $encryptedData = Crypt::encryptString(json_encode($reservationData));
            $payment_url = url('/') . '/payment?data=' . urlencode($encryptedData);

            return $this->response(['payment_url' => $payment_url], '', 200);
        });
    }*/

    /*public function store_reservation(HotelReservationRequest $request)
    {
        return DB::transaction(function () use ($request) {
            // Parse dates
            $startDatetime = Carbon::parse($request->start_date);
            $endDatetime = Carbon::parse($request->end_date);

            // Retrieve room information
            $roomIds = $request->room;
            $numberOfNights = $startDatetime->diffInDays($endDatetime);
            $roomsRequested = Room::where('id', $roomIds)->first();

            if (!$roomsRequested) {
                return $this->response('', 'Room not found.', 422);
            }

            $totalPrice = $roomsRequested->price_per_day * $numberOfNights;

            // Check for reservations overlapping the desired booking period
            $reservationsForRoom = HotelReservation::where('end_datetime', '>', $startDatetime)
                ->where('start_datetime', '<', $endDatetime)
                ->whereJsonContains('rooms', $roomsRequested->id)
                ->count();

            if ($reservationsForRoom >= $roomsRequested->count) {
                return $this->response('', 'Rooms of type ' . $roomsRequested->type . ' are fully booked in the requested period.', 422);
            }

            // Apply coupon if provided
            if ($request->has('coupon_code')) {
                $coupon = HotelCoupon::where('code', $request->coupon_code)->first();
                if ($coupon && $coupon->isValid()) {
                    $discountResult = $this->calculateDiscount($coupon, $totalPrice);

                    // Check if the result contains an error
                    if (isset($discountResult['error'])) {
                        return $this->response('', $discountResult['error'], 422);
                    }

                    $coupon->increment('usage_count');
                    // Apply the discount if no error
                    $totalPrice -= $discountResult['discount'];
                }
                else
                {
                    return $this->response('', 'Invalid or expired coupon.', 422);
                }
            }


            // Prepare reservation data
            $reservationData = [
                'hotel_id' => $request->hotel_id,
                'user_id' => Auth::guard('api')->user()->id,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'email' => $request->email,
                'adults' => $request->adults,
                'children' => $request->children,
                'rooms' => $roomIds,
                'total_price' => $totalPrice
            ];

            // Encrypt and create payment URL
            $encryptedData = Crypt::encryptString(json_encode($reservationData));
            $payment_url = url('/') . '/payment?data=' . urlencode($encryptedData);

            return $this->response(['payment_url' => $payment_url], '', 200);
        });
    }*/

    public function store_reservation(HotelReservationRequest $request)
    {
        return DB::transaction(function () use ($request) {
            // Parse dates
            $startDatetime = Carbon::parse($request->start_date);
            $endDatetime = Carbon::parse($request->end_date);

            // Retrieve room and hotel information
            $roomIds = $request->room;
            $hotelId = $request->hotel_id;
            $roomsRequested = Room::where('id', $roomIds)->first();
            $hotel = Hotel::find($hotelId);

            if (!$roomsRequested) {
                return $this->response('', 'Room not found.', 422);
            }

            if (!$hotel) {
                return $this->response('', 'Hotel not found.', 422);
            }

            // Calculate the total price based on the number of nights plus service fees
            $numberOfNights = $startDatetime->diffInDays($endDatetime) + 1;
            $totalPrice = $roomsRequested->price_per_day * $numberOfNights + $hotel->service_fees;

            // Check for reservations overlapping the desired booking period
            $reservationsForRoom = HotelReservation::where('end_datetime', '>', $startDatetime)
                ->where('start_datetime', '<', $endDatetime)
                ->where('rooms', $roomsRequested->id)
                ->count();

            if ($reservationsForRoom >= $roomsRequested->count) {
                return $this->response('', 'Rooms of type ' . $roomsRequested->type . ' are fully booked in the requested period.', 422);
            }

            // Apply coupon if provided
            if ($request->has('coupon_code')) {
                $coupon = HotelCoupon::where('code', $request->coupon_code)->first();
                if ($coupon && $coupon->isValid()) {
                    $discountResult = $this->calculateDiscount($coupon, $totalPrice);

                    // Check if the result contains an error
                    if (isset($discountResult['error'])) {
                        return $this->response('', $discountResult['error'], 422);
                    }

                    $coupon->increment('usage_count');
                    $totalPrice -= $discountResult['discount'];  // Apply the discount if no error
                } else {
                    return $this->response('', 'Invalid or expired coupon.', 422);
                }
            }

            // Prepare reservation data
            $reservationData = [
                'hotel_id' => $hotelId,
                'user_id' => Auth::guard('api')->user()->id,
                'start_date' => $startDatetime,
                'end_date' => $endDatetime,
                'email' => $request->email,
                'adults' => $request->adults,
                'children' => $request->children,
                'rooms' => $roomIds,
                'total_price' => $totalPrice
            ];

            // Encrypt and create payment URL
            $encryptedData = Crypt::encryptString(json_encode($reservationData));
            $payment_url = url('/') . '/payment?data=' . urlencode($encryptedData);

            return $this->response(['payment_url' => $payment_url], '', 200);
        });
    }


    private function calculateDiscount($coupon, $totalPrice)
    {
        if ($coupon->type === 'percentage') {
            $calculatedDiscount = $totalPrice * ($coupon->discount_percentage / 100);
            if ($calculatedDiscount > $coupon->maximum_discount) {
                return [
                    'error' => 'Discount exceeds maximum limit of ' . $coupon->maximum_discount,
                    'calculated_discount' => $calculatedDiscount,
                    'maximum_discount' => $coupon->maximum_discount
                ];
            }
            return ['discount' => $calculatedDiscount];
        }
        else {
            $discount = min($coupon->price, $totalPrice);
            return ['discount' => $discount];
        }
    }


    public function callback(Request $request)
    {

         return $this->moyasarService->handleCallback($request);
       // return redirect('/');
    }

}
