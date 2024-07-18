<?php

namespace App\Http\Controllers\Api\V1\Restaurant;

use Carbon\Carbon;
use App\Models\Restaurant;
use App\Http\Trait\ApiTrait;
use App\Http\Controllers\Controller;
use App\Models\RestaurantReservation;
use App\Http\Requests\Api\V1\RestaurantReservation\StoreRequest;
use App\Http\Requests\Api\V1\RestaurantReservation\UpdateRequest;
use Illuminate\Support\Facades\Auth;

class RestaurantReservationController extends Controller
{
    use ApiTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $restaurantReservations = RestaurantReservation::where('user_id', auth('api')->id())->with('restaurant')->get();
        return $this->response(['restaurant_reservations' => $restaurantReservations], 'restaurantReservation', 200);
    }

   
  
    public function store(StoreRequest $request)
    {
        // Find the restaurant
        $restaurant = Restaurant::findOrFail($request->restaurant_id);

        // Calculate the total price
        $totalPrice = $restaurant->price + $restaurant->service_fees;

        // Create the reservation
        $reservation = RestaurantReservation::create([
            'booking_date' => $request->booking_date,
            'phone' => $request->phone,
            'adults' => $request->adults,
            'children' => $request->children,
            'email' => $request->email,
            'user_id' => Auth::guard('api')->user()->id,
            'restaurant_id' => $request->restaurant_id,
            'total_price' => $totalPrice,
        ]);

        // Return the response
        return $this->response(['restaurantReservation' => $reservation], 'Restaurant Reservation added successfully', 201);
    }

  
    public function show($id)
    {
        $restaurantReservation = RestaurantReservation::where('user_id', auth('api')->id())->with('restaurant')->find($id);

        if (!$restaurantReservation)
            return $this->response('', 'This Restaurant Reservation does not exist', 404);

        return $this->response(['restaurant_reservations' => $restaurantReservation], 'restaurantReservation', 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, $id)
    {
        $restaurantReservation = RestaurantReservation::where('user_id', auth('api')->id())->find($id);
        //return $request->validated();

        if (!$restaurantReservation)
            return $this->response('', 'This Restaurant Reservation does not exist', 404);

        if ($restaurantReservation->status)
            return $this->response('', 'Cannot be modified', 403);

        $restaurantReservation->update($request->validated());

        return $this->response(['restaurantReservation' => $restaurantReservation->refrsh()], 'Restaurant Reservation Updated successfully', 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $restaurantReservation = RestaurantReservation::where('user_id', auth('api')->id())->find($id);

        if (!$restaurantReservation)
            return $this->response('', 'This Restaurant Reservation does not exist', 404);

        if ($restaurantReservation->status == 1 || $restaurantReservation->booking_date <= Carbon::now())
            return $this->response('', 'The reservation cannot be deleted because it has passed', 400);

        $restaurantReservation->restaurant->increment('table_available', 1);
        $restaurantReservation->delete();

        return $this->response('', 'Restaurant Reservation Deleted successfully', 200);
    }
}
