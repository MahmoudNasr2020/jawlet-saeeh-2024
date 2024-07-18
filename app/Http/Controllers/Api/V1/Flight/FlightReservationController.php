<?php

namespace App\Http\Controllers\Api\V1\Flight;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\FlightReservationRequest;
use App\Http\Trait\ApiTrait;
use App\Models\Airport;
use App\Models\FlightReservation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FlightReservationController extends Controller
{
    use ApiTrait;

    public function search(Request $request)
    {
         $query = $request->input('query');

      $airports = Airport::select('id','name_en','name_ar', 'region_en', 'region_ar','country_name_en','country_name_ar')
            ->where('name_en', 'LIKE', "%{$query}%")
            ->orWhere('name_ar', 'LIKE', "%{$query}%")
            ->orWhere('region_en', 'LIKE', "%{$query}%")
            ->orWhere('region_ar', 'LIKE', "%{$query}%")
            ->get();

        return $this->response(['airports'=>$airports],'',200);
    }

    public function addReservation(FlightReservationRequest $request)
    {

        $startDatetime = Carbon::parse($request->start_datetime);
        $endDatetime = $request->type === 'round_trip' ? Carbon::parse($request->end_datetime) : null;


        $reservation = new FlightReservation([
            'type' => $request->type,
            'from_airport_id' => $request->from_airport_id,
            'to_airport_id' => $request->to_airport_id,
            'start_datetime' => $startDatetime,
            'end_datetime' => $endDatetime,
            'number_of_persons'=> $request->number_of_persons,
            'class' => $request->class,
            'user_id' => Auth::guard('api')->user()->id,
        ]);

        $reservation->save();

        $reservation->load([
            'user:id,first_name,last_name,phone',
            'fromAirport:id,name_en,name_ar',
            'toAirport:id,name_en,name_ar'
        ]);

        $startDatetimeFormatted = $startDatetime->format('d-m-Y H:i');
        $endDatetimeFormatted = $endDatetime != null ? $endDatetime->format('d-m-Y H:i') : '';

        $reservation->start_datetime = $startDatetimeFormatted;
       $reservation->end_datetime = $endDatetimeFormatted;

        return $this->response(['reservation' => $reservation->only(['id', 'type', 'start_datetime', 'end_datetime', 'number_of_persons', 'class','user','fromAirport', 'toAirport']),], 'Your reservation has been completed successfully', 201);
    }
}
