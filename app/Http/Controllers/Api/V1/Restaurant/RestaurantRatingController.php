<?php

namespace App\Http\Controllers\Api\V1\Restaurant;

use App\Http\Controllers\Controller;
use App\Http\Trait\ApiTrait;
use App\Models\RestaurantRating;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RestaurantRatingController extends Controller
{
    use ApiTrait;

    public function rating(Request $request)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'restaurant_id' => [
                'required',
                Rule::exists('restaurants', 'id'),
            ],
            'comment' => 'nullable|string|max:255'
        ]);

        $rating = RestaurantRating::updateOrCreate([
            'user_id' => auth()->guard('api')->user()->id,
            'restaurant_id' => $request->restaurant_id,
        ],
            [
                'rating' => $request->rating,
                'comment' => $request->comment
            ]);

        return $this->response($rating, 'Rating added successfully!', 201);
    }


    public function deleteRating($id)
    {
        $rating = RestaurantRating::where('id', $id)
            ->where('user_id', auth()->guard('api')->user()->id)
            ->first();

        if (!$rating) {
            return $this->response(null, 'Rating not found or not authorized', 404);
        }

        $rating->delete();

        return $this->response(null, 'Rating deleted successfully', 200);
    }

}
