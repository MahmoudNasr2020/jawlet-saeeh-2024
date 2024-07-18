<?php

use App\Http\Controllers\Dashboard\Auth\AuthController;
use App\Http\Controllers\Dashboard\Flight\FlightReservationController;
use App\Http\Controllers\Dashboard\HomeController;
use App\Http\Controllers\Dashboard\Hotel\CouponController;
use App\Http\Controllers\Dashboard\Hotel\HotelController;
use App\Http\Controllers\Dashboard\Hotel\HotelReservationsController;
use App\Http\Controllers\Dashboard\Hotel\RoomController;
use App\Http\Controllers\Dashboard\Profile\ProfileController;
use App\Http\Controllers\Dashboard\RentalCar\RentalCarCitiesController;
use App\Http\Controllers\Dashboard\RentalCar\RentalCarController;
use App\Http\Controllers\Dashboard\RentalCar\RentalCarDepartmentController;
use App\Http\Controllers\Dashboard\RentalCar\RentalCarReservationsController;
use App\Http\Controllers\Dashboard\Restaurant\RestaurantController;
use App\Http\Controllers\Dashboard\Site\AboutController;
use App\Http\Controllers\Dashboard\Site\MoyasarPaymentSettingController;
use App\Http\Controllers\Dashboard\Site\PartnerController;
use App\Http\Controllers\Dashboard\Site\ServiceController;
use App\Http\Controllers\Dashboard\Site\SettingController;
use App\Http\Controllers\Dashboard\Site\SliderController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\Restaurant\RestaurantRegistrationController;




// guest-login
Route::group(['middleware'=>'guest:admin'],function (){

    Route::get('login',[AuthController::class,'index'])->name('login.index');
    Route::post('confirm-login',[AuthController::class,'login'])->name('login.confirm');
});

Route::group(['middleware'=>'auth:admin'],function (){

    //logout
    Route::post('logout',[AuthController::class,'logout'])->name('logout');

    // rental-car-departments
    Route::resource('rental-car-departments', RentalCarDepartmentController::class);

// rental-cars
    Route::resource('rental-cars', RentalCarController::class);
    Route::get('rental-cars/multi_images/{rental_car_id}', [RentalCarController::class, 'multi_images'])->name('rental-cars.multi_images');
    Route::post('rental-cars/upload_multi_images', [RentalCarController::class, 'upload_multi_images'])->name('rental-cars.upload_multi_images');
    Route::post('/delete_image', [RentalCarController::class, 'delete_image'])->name('rental-cars.delete_image');


// rental-car-cities
    Route::resource('rental-car-cities', RentalCarCitiesController::class);

    // rental-car-reservations
    Route::get('rental-car-reservations/current_reservations',[RentalCarReservationsController::class,'current_reservations'])->name('rental-car-reservations.current_reservations');
    Route::get('rental-car-reservations/expired_reservations',[RentalCarReservationsController::class,'expired_reservations'])->name('rental-car-reservations.expired_reservations');
    Route::get('rental-car-reservations/upcoming_reservations',[RentalCarReservationsController::class,'upcoming_reservations'])->name('rental-car-reservations.upcoming_reservations');
    Route::get('rental-car-reservations/expected_reservations',[RentalCarReservationsController::class,'expected_reservations'])->name('rental-car-reservations.expected_reservations');
    Route::get('rental-car-reservations/{id}',[RentalCarReservationsController::class,'show'])->name('rental-car-reservations-show');
    Route::post('rental-car-reservations/send-contract',[RentalCarReservationsController::class,'send_contract'])->name('rental-car-reservations.send-contract');
    Route::post('rental-car-reservations/active-reservation',[RentalCarReservationsController::class,'active_reservation'])->name('rental-car-reservations.active-reservation');
    Route::delete('rental-car-reservations/destroy/{id}',[RentalCarReservationsController::class,'destroy'])->name('rental-car-reservations.destroy');

  //  Route::get('rental-car/get-new-reservations', [RentalCarReservationsController::class, 'getNewNotifications'])->name('rental-car-reservations.get-new-reservations');
    Route::post('rental-car/mark-as-viewed-reservations', [RentalCarReservationsController::class, 'markAsViewed'])->name('rental-car-reservations.mark-as-viewed-reservations');


    // hotels
    Route::resource('hotels', HotelController::class);
    Route::get('hotels-overview', [HotelController::class, 'overview'])->name('hotels.overview');
    Route::get('hotels/multi_images/{rental_car_id}', [HotelController::class, 'multi_images'])->name('hotels.multi_images');
    Route::post('hotels/upload_multi_images', [HotelController::class, 'upload_multi_images'])->name('hotels.upload_multi_images');
    Route::post('hotels/delete_image', [HotelController::class, 'delete_image'])->name('hotels.delete_image');

    // hotels rooms
    Route::get('rooms', [HotelController::class, 'rooms'])->name('hotels.rooms.index');
    Route::get('available-rooms', [RoomController::class, 'available_rooms'])->name('hotels.rooms.available_rooms');
    Route::get('{hotel_id}/rooms', [RoomController::class, 'index'])->name('rooms.index');
    Route::get('{hotel_id}/rooms/create', [RoomController::class, 'create'])->name('rooms.create');
    Route::post('/rooms', [RoomController::class, 'store'])->name('rooms.store');
    Route::get('/rooms/{id}', [RoomController::class, 'show'])->name('rooms.show');
    Route::get('{hotel_id}/rooms/{id}', [RoomController::class, 'edit'])->name('rooms.edit');
    Route::put('/rooms/{id}', [RoomController::class, 'update'])->name('rooms.update');
    Route::delete('/rooms/{id}', [RoomController::class, 'destroy'])->name('rooms.destroy');


    //hotels reservation
    Route::get('hotels-reservations/current_reservations',[HotelReservationsController::class,'current_reservations'])->name('hotels-reservations.current_reservations');
    Route::get('hotels-reservations/expired_reservations',[HotelReservationsController::class,'expired_reservations'])->name('hotels-reservations.expired_reservations');
    Route::get('hotels-reservations/upcoming_reservations',[HotelReservationsController::class,'upcoming_reservations'])->name('hotels-reservations.upcoming_reservations');
    Route::get('hotels-reservations/expected_reservations',[HotelReservationsController::class,'expected_reservations'])->name('hotels-reservations.expected_reservations');
    Route::get('hotels-reservations/canceled_reservations',[HotelReservationsController::class,'canceled_reservations'])->name('hotels-reservations.canceled_reservations');
    Route::get('hotels-reservations/{id}',[HotelReservationsController::class,'show'])->name('hotels-reservations-show');
    Route::post('hotels-reservations/cancel-reservation',[HotelReservationsController::class,'cancel_reservation'])->name('hotels-reservations.cancel-reservation');
    Route::post('hotels-reservations/active-reservation',[HotelReservationsController::class,'active_reservation'])->name('hotels-reservations.active-reservation');
    Route::delete('hotels-reservations/destroy/{id}',[HotelReservationsController::class,'destroy'])->name('hotels-reservations.destroy');

    // services
    Route::resource('hotel-coupons', CouponController::class);

    // restaurants
    Route::resource('restaurants', RestaurantController::class);
    Route::resource('restaurant-registrations', RestaurantRegistrationController::class)->except(['create', 'store', 'update', 'edit']);


    //flight reservation
    Route::get('flight-overview', [FlightReservationController::class, 'overview'])->name('flight.overview');
    Route::get('flight-reservations/current_reservations',[FlightReservationController::class,'current_reservations'])->name('flight-reservations.current_reservations');
    Route::get('flight-reservations/expired_reservations',[FlightReservationController::class,'expired_reservations'])->name('flight-reservations.expired_reservations');
    Route::get('flight-reservations/upcoming_reservations',[FlightReservationController::class,'upcoming_reservations'])->name('flight-reservations.upcoming_reservations');
    Route::get('flight-reservations/expected_reservations',[FlightReservationController::class,'expected_reservations'])->name('flight-reservations.expected_reservations');
    Route::get('flight-reservations/canceled_reservations',[FlightReservationController::class,'canceled_reservations'])->name('flight-reservations.canceled_reservations');
    Route::get('flight-reservations/{id}',[FlightReservationController::class,'show'])->name('flight-reservations-show');
    Route::post('flight-reservations/cancel-reservation',[FlightReservationController::class,'cancel_reservation'])->name('flight-reservations.cancel-reservation');
    Route::post('flight-reservations/active-reservation',[FlightReservationController::class,'active_reservation'])->name('flight-reservations.active-reservation');
    Route::delete('flight-reservations/destroy/{id}',[FlightReservationController::class,'destroy'])->name('flight-reservations.destroy');


    // sliders
    Route::resource('sliders', SliderController::class);

    // partners
    Route::resource('partners', PartnerController::class);

    // services
    Route::resource('services', ServiceController::class);

    // about
    Route::get('about-us', [AboutController::class,'index'])->name('about.index');
    Route::put('update-about-us/{id}', [AboutController::class,'update'])->name('about.update');

    // setting
    Route::get('settings', [SettingController::class,'index'])->name('setting.index');
    Route::put('settings/{id}', [SettingController::class,'update'])->name('setting.update');

    // moyasar payment setting
    Route::get('moyasar-payment-setting', [MoyasarPaymentSettingController::class,'index'])->name('moyasar-payment-setting.index');
    Route::put('moyasar-payment-setting/{id}', [MoyasarPaymentSettingController::class,'update'])->name('moyasar-payment-setting.update');


    //profile
    Route::get('profile', [ProfileController::class,'index'])->name('profile.index');
    Route::put('profile/update', [ProfileController::class,'update'])->name('profile.update');

    // home
    Route::get('home', [HomeController::class,'index'])->name('home.index');

});


