<?php

use App\Http\Controllers\Site\HomeController;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Route;
use Stichoza\GoogleTranslate\GoogleTranslate;
use App\Http\Controllers\Site\RestaurantRegistrationController;



ini_set('max_execution_time', 3000000);

Route::get('clear',function (){
    \Illuminate\Support\Facades\Artisan::call('config:cache');
});



Route::get('/', [HomeController::class,'index']);
Route::get('services', [HomeController::class,'services'])->name('site.services');
Route::get('about-us', [HomeController::class,'about'])->name('site.about');
Route::get('contact-us', [HomeController::class,'contact'])->name('site.contact');
Route::post('contact', [HomeController::class,'contact_us'])->name('site.contact_us');
Route::get('partners', [HomeController::class,'partners'])->name('site.partner');
Route::get('airports', [HomeController::class,'translateEnglishNamedAirports'])->name('site.airports');


Route::get('delete-account', [HomeController::class,'delete_account']);
Route::post('delete-account', [HomeController::class,'confirm_delete_account'])->name('site.delete_account');

Route::get('privacy_policy', [HomeController::class,'privacy_policy'])->name('site.privacy_policy');

//payment
Route::get('payment-success',function (){
    return view('site.pages.payment_success');
})->name('site.payment-success');

Route::get('payment-failed',function (){
    return view('site.pages.payment_failed');
})->name('site.payment-failed');

Route::get('payment',function (){
    return view('site.pages.payment');
})->name('site.payment');


Route::get('changeLanguage/{language}', [HomeController::class,'changeLanguage'])->name('site.change_language');


Route::post('/restaurants', [RestaurantRegistrationController::class, 'store'])->name('restaurantsRegistration.store');