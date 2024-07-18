<?php

namespace App\Http\Controllers\Api\V1\RentalCar;

use App\Http\Controllers\Controller;
use App\Http\Trait\ApiTrait;
use App\Models\RentalCarRating;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RentalCarRatingController extends Controller
{
    use ApiTrait;

    public function rating(Request $request)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'rental_car_id' => [
                'required',
                Rule::exists('rental_cars', 'id'),
            ],
        ]);

        $rating = RentalCarRating::updateOrCreate([
            'user_id' => auth()->guard('api')->user()->id,
            'rental_car_id' => $request->rental_car_id
        ],
            ['rating' => $request->rating]);

        return $this->response($rating, 'Rating added successfully!', 201); // 409 Conflict
    }

}
