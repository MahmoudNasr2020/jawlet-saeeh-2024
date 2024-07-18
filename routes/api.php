<?php

use App\Http\Controllers\Api\V1\Auth\AuthController;
use App\Http\Controllers\Api\V1\Flight\FlightReservationController;
use App\Http\Controllers\Api\V1\Hotel\CouponController;
use App\Http\Controllers\Api\V1\Hotel\HotelController;
use App\Http\Controllers\Api\V1\Hotel\HotelFavoriteController;
use App\Http\Controllers\Api\V1\Hotel\HotelRatingController;
use App\Http\Controllers\Api\V1\Hotel\HotelReservationController;
use App\Http\Controllers\Api\V1\Profile\ProfileController;
use App\Http\Controllers\Api\V1\RentalCar\RentalCarController;
use App\Http\Controllers\Api\V1\RentalCar\RentalCarFavoriteController;
use App\Http\Controllers\Api\V1\RentalCar\RentalCarRatingController;
use App\Http\Controllers\Api\V1\RentalCar\RentalCarReservationController;
use App\Http\Controllers\Api\V1\Restaurant\RestaurantController;
use App\Http\Controllers\Api\V1\Restaurant\RestaurantReservationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\User\FavoriteController;
use App\Http\Controllers\Api\V1\User\ReservationController;
use App\Http\Controllers\Api\V1\Home\HomeController;
use App\Http\Controllers\Api\V1\Restaurant\RestaurantFavoriteController;
use App\Http\Controllers\Api\V1\Restaurant\RestaurantRatingController;
use App\Http\Controllers\Api\V1\User\UserController;
use App\Http\Controllers\Api\V1\InternalTrip\InternalTripController;
use App\Http\Controllers\Api\V1\InternalTrip\InternalTripReservationController;
use App\Http\Controllers\Api\V1\PilgrimageTrip\PilgrimageTripController;
use App\Http\Controllers\Api\V1\PilgrimageTrip\PilgrimageTripReservationController;
use App\Http\Controllers\Api\V1\ExternalTrip\ExternalTripController;
use App\Http\Controllers\Api\V1\ExternalTrip\ExternalTripReservationController;
use App\Http\Controllers\Api\V1\TouristGuide\TouristGuideController;
use App\Http\Controllers\Api\V1\TouristGuide\TouristGuideReservationController;

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});


// Route V1
Route::group(['prefix'=>'v1/','as'=>'v1'],function (){

    Route::group(['middleware'=>'guest:api'],function (){
        Route::post('register',[AuthController::class,'register']);
        Route::post('checkOpt',[AuthController::class,'checkOtp']);
        Route::post('resendOpt',[AuthController::class,'resend_otp']);
        Route::post('login',[AuthController::class,'login']);
        Route::post('forget_password',[AuthController::class,'forget_password']);
        Route::post('confirm_forget_password',[AuthController::class,'confirm_forget_password']);
        Route::post('change_password',[AuthController::class,'change_password']);
        Route::post('resendPasswordOpt',[AuthController::class,'resend_password_otp']);

    });

    Route::group(['middleware'=>['auth:api','user_verify']],function (){
        Route::post('logout',[AuthController::class,'logout']);

            //car rental favorite
            Route::get('/rental_car_favorites', [RentalCarFavoriteController::class, 'index']);
            Route::post('/rental_car_favorites/add', [RentalCarFavoriteController::class, 'addToFavorites']);
            Route::post('/rental_car_favorites/remove', [RentalCarFavoriteController::class, 'removeFromFavorites']);

            //Rental car reservation
            Route::post('rental_car_reservations/add', [RentalCarReservationController::class,'store']);

        //Rental car rating
        Route::post('rental_car_rating', [RentalCarRatingController::class,'rating']);

        //Hotel rating
        Route::post('hotel_rating', [HotelRatingController::class,'rating']);

        //hotel favorite
        Route::get('/hotel_favorites', [HotelFavoriteController::class, 'index']);
        Route::post('/hotel_favorites/add', [HotelFavoriteController::class, 'addToFavorites']);
        Route::post('/hotel_favorites/remove', [HotelFavoriteController::class, 'removeFromFavorites']);

        //hotel reservation
        Route::post('/hotel_reservations/add', [HotelReservationController::class, 'store_reservation']);

        //hotel reservation
        Route::post('/hotel_coupons/apply', [CouponController::class, 'apply_coupon']);

        //hotel reservation callback



        // profile
        Route::group(['prefix'=>'profile'],function(){
            Route::post('update',[ProfileController::class,'update_profile']);
            Route::get('show',[ProfileController::class,'show_profile']);
        });

        // Restaurants
        Route::get('restaurants/reservations', [RestaurantReservationController::class, 'index']);
        Route::get('restaurants/reservations/{restaurantReservation}', [RestaurantReservationController::class, 'show']);
        Route::post('restaurants/reservations', [RestaurantReservationController::class, 'store']);
        Route::put('restaurants/reservations/{restaurantReservation}', [RestaurantReservationController::class, 'update']);
        Route::delete('restaurants/reservations/{restaurantReservation}', [RestaurantReservationController::class, 'destroy']);

        // Restaurant favorites
        Route::get('/restaurant_favorites', [RestaurantFavoriteController::class, 'index']);
        Route::post('/restaurant_favorites/add', [RestaurantFavoriteController::class, 'addToFavorites']);
        Route::post('/restaurant_favorites/remove', [RestaurantFavoriteController::class, 'removeFromFavorites']);

        // Restaurant Rating
        Route::post('restaurant/rating', [RestaurantRatingController::class, 'rating']);
        Route::post('restaurant/rating/{id}', [RestaurantRatingController::class, 'deleteRating']);
     


        // Flight
        Route::post('/flight-reservation/add', [FlightReservationController::class, 'addReservation']);
      
              //internal-trip-reservations
        Route::post('internal-trip-reservations', [InternalTripReservationController::class, 'store']);

        //external-trip-reservations
        Route::post('external-trip-reservations', [ExternalTripReservationController::class, 'store']);

        //pilgrimage-trip-reservations
        Route::post('pilgrimage-trip-reservations', [PilgrimageTripReservationController::class, 'store']);
      
        // Tourist guide reservations
        Route::post('tourist-guide-reservations', [TouristGuideReservationController::class, 'store']);
      
      
       //favorite user
        Route::get('/user/favorites', [FavoriteController::class, 'favorites']);
      
       //reservations user
        Route::get('/user/hotel-reservations', [ReservationController::class, 'hotelReservations']);
        Route::get('/user/car-reservations', [ReservationController::class, 'carReservations']);
        Route::get('/user/flight-reservations', [ReservationController::class, 'flightReservations']);
        Route::get('/user/restaurant-reservations', [ReservationController::class, 'restaurantReservations']);
      
        // Delete account user
        Route::post('user/delete-account', [UserController::class, 'deleteAccount']);
       

    });
  
   //notifications
    Route::get('/notifications', function (){
        return response()->json(['data'=>[],'msg'=>'notifications'],200);
    });


    Route::get('/hotel_reservations/callback', [HotelReservationController::class, 'callback']);

    //Rental Car
    Route::get('/cars_departments',[RentalCarController::class,'cars_departments']);
    Route::get('/car_department/{car_department_id}',[RentalCarController::class,'car_department_show']);
    Route::get('/rental_car_show/{rental_car_id}',[RentalCarController::class,'rental_car_show']);
    Route::get('/rental_car_cities',[RentalCarController::class,'rental_car_cities']);
    Route::get('/rental_car_most_wanted',[RentalCarController::class,'rental_car_most_wanted']);


    //Hotel
    Route::get('/hotels',[HotelController::class,'index']);
    Route::get('/hotel/{hotel_id}',[HotelController::class,'show']);
    Route::get('/hotel_show_more/{hotel_id}',[HotelController::class,'show_more']);
    Route::get('/hotel_most_wanted',[HotelController::class,'hotels_most_wanted']);
    Route::get('/get_rooms/{hotel_id}',[HotelController::class,'get_rooms']);
  
   //resturent
    Route::get('restaurants', [RestaurantController::class, 'index']);
    Route::get('restaurants/{restaurant}', [RestaurantController::class, 'show']);

    //Flight
    Route::get('flight-reservation/search', [FlightReservationController::class, 'search']);
  
   //internal trips
    Route::get('internal-trips', [InternalTripController::class, 'index']);
    Route::get('internal-trips/{id}', [InternalTripController::class, 'show']);

    //external trips
    Route::get('external-trips', [ExternalTripController::class, 'index']);
    Route::get('external-trips/{id}', [ExternalTripController::class, 'show']);

    // pilgrimage trips
    Route::get('pilgrimage-trips', [PilgrimageTripController::class, 'index']);
    Route::get('pilgrimage-trips/{id}', [PilgrimageTripController::class, 'show']);
  
   // Tourist guides
    Route::get('tourist-guides', [TouristGuideController::class, 'index']);
    Route::get('reservation-data/{id}', [TouristGuideController::class, 'reservation_data']);
  
  
  	//home page
    Route::get('/home', [HomeController::class, 'index']);

});
