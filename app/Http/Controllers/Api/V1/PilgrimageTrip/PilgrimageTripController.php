<?php

namespace App\Http\Controllers\Api\V1\PilgrimageTrip;

use App\Http\Controllers\Controller;
use App\Models\PilgrimageTrip;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Trait\ApiTrait;

class PilgrimageTripController extends Controller
{
    use ApiTrait;

    public function index(Request $request): JsonResponse
    {
        try {
            $trips = PilgrimageTrip::all();

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

            return $this->response($trips, 'Pilgrimage trips fetched successfully', 200);
        } catch (\Exception $e) {
            return $this->response(null, 'Failed to fetch pilgrimage trips', 500);
        }
    }

    public function show($id): JsonResponse
    {
        try {
            $trip = PilgrimageTrip::find($id);

            if (!$trip) {
                return $this->response(null, 'Pilgrimage trip not found', 404);
            }

            return $this->response([
               'id' => $trip->id,
                'name' => $trip->name,
                'main_image' => $trip->main_image,
                'price_per_person' => (double) $trip->price_per_person,
                'location' => $trip->location,
                'description' => $trip->description,
                'start_date' => $trip->start_date,
                'end_date' => $trip->end_date,
                'images' => $trip->images,
                'days_count' => $trip->days_count,
            ], 'Pilgrimage trip fetched successfully', 200);
        } catch (\Exception $e) {
            return $this->response(null, 'Failed to fetch pilgrimage trip', 500);
        }
    }
}
