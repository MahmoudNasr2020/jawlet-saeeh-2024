<?php

namespace App\Http\Controllers\Api\V1\TouristGuide;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\TouristGuideReservation\TouristGuideReservationRequest;
use App\Models\TouristGuideReservation;
use App\Models\TouristGuide;
use App\Models\TouristGuidePlace;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use App\Http\Trait\ApiTrait;
use Illuminate\Support\Facades\Auth;

class TouristGuideReservationController extends Controller
{
    use ApiTrait;

    public function store(TouristGuideReservationRequest $request): JsonResponse
    {
        try {
            $validated = $request->validated();

            $guide = TouristGuide::find($validated['tourist_guide_id']);
            $place = TouristGuidePlace::find($validated['tourist_guide_place_id']);

            $from_date = Carbon::createFromFormat('Y-m-d', $validated['from_date']);
            $to_date = Carbon::createFromFormat('Y-m-d', $validated['to_date']);

            $reservation = TouristGuideReservation::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'from_date' => $validated['from_date'],
                'to_date' => $validated['to_date'],
                'tourist_guide_id' => $guide->id,
                'tourist_guide_place_id' => $place->id,

            ]);

            return $this->response($reservation, 'Reservation created successfully', 201);
        } catch (\Exception $e) {
            return $this->response(null, 'Failed to create reservation', 500);
        }
    }
}
