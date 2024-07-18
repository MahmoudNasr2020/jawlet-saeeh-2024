<?php

namespace App\Http\Controllers\Api\V1\Hotel;

use App\Http\Controllers\Controller;
use App\Http\Trait\ApiTrait;
use App\Models\Hotel;
use App\Models\HotelCoupon;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    use ApiTrait;
   /* public function apply_coupon(Request $request)
    {
        // Receive request data
        $couponCode = $request->coupon_code;
        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);
        $roomId = $request->room;

        // Retrieve room information
        $room = Room::find($roomId);
        if (!$room) {
            return $this->response('', 'Room not found', 404);
        }

        // Calculate the total price based on the number of nights
        $numberOfNights = $startDate->diffInDays($endDate);
        $totalPrice = $room->price_per_day * $numberOfNights;

        // Retrieve coupon details
        $coupon = HotelCoupon::where('code', $couponCode)->first();
        if (!$coupon || $coupon->usage_count >= $coupon->usage_limit || $coupon->expiry_date < now()) {
            return $this->response('', 'Invalid or expired coupon', 422);
        }

        // Apply coupon discount
        $discount = 0;
        if ($coupon->type == 'price') {
            $discount = min($coupon->price, $totalPrice); // Ensure discount does not exceed total price
        }
        elseif ($coupon->type == 'percentage') {
            $calculatedDiscount = $totalPrice * ($coupon->discount_percentage / 100);
            if ($calculatedDiscount > $coupon->maximum_discount) {
                return $this->response(['max_allowed_discount'=>$coupon->maximum_discount], 'The discount exceeds the maximum allowed discount limit.', 422);
            }
            else {
                $discount = $calculatedDiscount;  // Apply the calculated discount
            }
        }


        // Update the total price
        $old_price = $totalPrice;
        $totalPrice -= $discount;

        // Update coupon usage
        //$coupon->increment('usage_count');

        // Return the new price with the applied discount
        return $this->response([
            'new_price' => $totalPrice,
            'old_price' => $old_price,
            'coupon_code' => $couponCode,
            'discount' => $discount
        ], 'The coupon is available for use.', 200);

    }*/


    public function apply_coupon(Request $request)
    {
        // Receive request data
        $couponCode = $request->coupon_code;
        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);
        $roomId = $request->room;
        $hotelId = $request->hotel_id; // Receive hotel ID

        // Retrieve room information
        $room = Room::find($roomId);
        if (!$room) {
            return $this->response('', 'Room not found', 404);
        }

        // Retrieve hotel service fees
        $hotel = Hotel::find($hotelId);
        if (!$hotel) {
            return $this->response('', 'Hotel not found', 404);
        }

        // Calculate the total price based on the number of nights
        $numberOfNights = $startDate->diffInDays($endDate) + 1;
        $totalPrice = $room->price_per_day * $numberOfNights + $hotel->service_fees; // Add service fees

        // Retrieve coupon details
        $coupon = HotelCoupon::where('code', $couponCode)->first();
        if (!$coupon || $coupon->usage_count >= $coupon->usage_limit || ($coupon->expiry_date != '' && $coupon->expiry_date < now()) ) {
            return $this->response('', 'Invalid or expired coupon', 422);
        }


        // Apply coupon discount
        $discount = 0;
        if ($coupon->type == 'price') {
            $discount = min($coupon->price, $totalPrice); // Ensure discount does not exceed total price
        }
        elseif ($coupon->type == 'percentage') {
            $calculatedDiscount = $totalPrice * ($coupon->discount_percentage / 100);
            if ($calculatedDiscount > $coupon->maximum_discount) {
                return $this->response(['max_allowed_discount'=>$coupon->maximum_discount], 'The discount exceeds the maximum allowed discount limit.', 422);
            }
            else {
                $discount = $calculatedDiscount;  // Apply the calculated discount
            }
        }

        // Update the total price after discount
        $old_price = $totalPrice;
        $totalPrice -= $discount;

        // Update coupon usage
        //$coupon->increment('usage_count');

        // Return the new price with the applied discount
        return $this->response([
            'new_price' => $totalPrice,
            'old_price' => $old_price,
            'coupon_code' => $couponCode,
            'discount' => $discount
        ], 'The coupon is available for use.', 200);
    }


}
