<?php

namespace App\Http\Controllers\Api\V1\Hotel;

use App\Http\Controllers\Controller;
use App\Http\Trait\ApiTrait;
use App\Models\HotelRating;
use App\Models\RentalCarRating;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class HotelRatingController extends Controller
{
    use ApiTrait;

    public function rating(Request $request)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'hotel_id' => [
                'required',
                Rule::exists('hotels', 'id'),
            ],
        ]);

        $rating = HotelRating::updateOrCreate([
            'user_id' => auth()->guard('api')->user()->id,
            'hotel_id' => $request->hotel_id,
        ],
            [
                'rating' => $request->rating
            ,'comment' => $request->comment
            ]);

        return $this->response($rating, 'Rating added successfully!', 201); // 409 Conflict
    }
}
