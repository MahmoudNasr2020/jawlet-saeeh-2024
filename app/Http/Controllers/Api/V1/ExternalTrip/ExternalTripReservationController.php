<?php

namespace App\Http\Controllers\Api\V1\ExternalTrip;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\ExternalTrip\ExternalTripReservationRequest;
use App\Models\ExternalTrip;
use App\Models\ExternalTripReservation;
use Illuminate\Http\JsonResponse;
use App\Http\Trait\ApiTrait;
use Illuminate\Support\Facades\Auth;

class ExternalTripReservationController extends Controller
{
    use ApiTrait;

    public function store(ExternalTripReservationRequest $request): JsonResponse
    {
        try {
            $validated = $request->validated();

            $trip = ExternalTrip::find($validated['external_trip_id']);
            $total_people = $validated['adults_count'] + $validated['children_count'];
            $total_price = $total_people * $trip->price_per_person;

            $reservation = ExternalTripReservation::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'adults_count' => $validated['adults_count'],
                'children_count' => $validated['children_count'],
                'total_price' => $total_price,
                'user_id' => Auth::guard('api')->user()->id,
                'external_trip_id' => $trip->id,
            ]);

            $reservation->days_count = $trip->days_count;
            $reservation->start_date = $trip->start_date;

            return $this->response($reservation, 'Reservation created successfully', 201);
        } catch (\Exception $e) {
            return $this->response(null, 'Failed to create reservation', 500);
        }
    }
}
