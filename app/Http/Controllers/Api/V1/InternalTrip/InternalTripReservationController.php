<?php

namespace App\Http\Controllers\Api\V1\InternalTrip;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\InternalTrip\InternalTripReservationRequest;
use App\Models\InternalTrip;
use App\Models\InternalTripReservation;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Trait\ApiTrait;
use Illuminate\Support\Facades\Auth;

class InternalTripReservationController extends Controller
{
    use ApiTrait;

    public function store(InternalTripReservationRequest $request): JsonResponse
    {
        try {
            $validated = $request->validated();

            $trip = InternalTrip::find($validated['internal_trip_id']);
            $total_people = $validated['adults_count'] + $validated['children_count'];
            $total_price = $total_people * $trip->price_per_person;

            $reservation = InternalTripReservation::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'adults_count' => $validated['adults_count'],
                'children_count' => $validated['children_count'],
                'total_price' => $total_price,
                'user_id' => Auth::guard('api')->user()->id,
                'internal_trip_id' => $trip->id,
            ]);
            $reservation->days_count = $trip->days_count;
            $reservation->start_date = $trip->start_date;

            return $this->response($reservation, 'Reservation created successfully', 201);
        }
        catch (\Exception $e) {
            return $this->response(null, 'Failed to create reservation', 500);
        }
    }
}
