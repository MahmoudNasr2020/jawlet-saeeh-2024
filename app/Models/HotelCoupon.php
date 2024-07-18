<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotelCoupon extends Model
{
    use HasFactory;
    protected $fillable = ['code', 'type', 'discount_percentage', 'maximum_discount', 'price', 'expiry_date', 'usage_count', 'usage_limit'];

    public function isValid()
    {
        return $this->usage_count < $this->usage_limit && ($this->expiry_date == '' || $this->expiry_date > now());
    }


    /* public function canApply($startDatetime, $endDatetime, $room)
     {

         $isWithinBookingDates = $startDatetime >= Carbon::parse($this->valid_from) && $endDatetime <= Carbon::parse($this->valid_until);

         $isRoomAllowed = in_array($room->type, $this->allowed_room_types);

         return $isWithinBookingDates && $isRoomAllowed;
     }*/


}
