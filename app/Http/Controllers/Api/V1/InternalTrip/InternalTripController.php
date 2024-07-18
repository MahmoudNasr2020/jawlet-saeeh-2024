<?php

namespace App\Http\Controllers\Api\V1\InternalTrip;

use App\Http\Controllers\Controller;
use App\Models\InternalTrip;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Trait\ApiTrait;

class InternalTripController extends Controller
{
    use ApiTrait;

    public function index(Request $request): JsonResponse
    {
        try {
            $trips = InternalTrip::all();

            $trips = $trips->map(function ($trip) {
                return [
                    'id' => $trip->id,
                  'name' => $trip->name,
                    'main_image' => $trip->main_image,
                    'price_per_person' => (double) $trip->price_per_person,
                    'location' => $trip->location,
                    'description' => $trip->description,
                    'start_date' => $trip->start_date,
                    'days_count' => $trip->days_count,
                ];
            });

            return $this->response($trips, 'Internal trips fetched successfully', 200);
        } catch (\Exception $e) {
            return $this->response(null, 'Failed to fetch internal trips', 500);
        }
    }

    public function show($id): JsonResponse
    {
        try {
            $trip = InternalTrip::find($id);

            if (!$trip) {
                return $this->response(null, 'Internal trip not found', 404);
            }

            $trip->price_per_person = (double) $trip->price_per_person;

            return $this->response([
               'id' => $trip->id,
                'name' => $trip->name,
                'main_image' => $trip->main_image,
                'price_per_person' => $trip->price_per_person,
                'location' => $trip->location,
                'description' => $trip->description,
                'start_date' => $trip->start_date,
                'end_date' => $trip->end_date,
                'images' => $trip->images,
                'days_count' => $trip->days_count,
            ], 'Internal trip fetched successfully', 200);
        } catch (\Exception $e) {
            return $this->response(null, 'Failed to fetch internal trip', 500);
        }
    }
}
