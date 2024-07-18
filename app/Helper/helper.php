<?php


use App\Models\MoyasarPayment;
use App\Models\Setting;

if (!function_exists('settings')) {
    function settings() {
        $settings = Setting::first();

        return $settings;
    }
}


if (!function_exists('moyasar_payment_settings')) {
    function moyasar_payment_settings() {

        $moyasar_payment = MoyasarPayment::first();

        return $moyasar_payment;
    }
}

if (!function_exists('successResponse')) {
    function successResponse(string $message = 'Success Response', int $status = 200)
    {
        return response()->json([
            'message'    => $message,
        ], $status);
    }
}

if (!function_exists('successResponseKeyWithValue')) {
    function successResponseKeyWithValue(string $key = 'data', string|array|object $data = 'Success Response', string $message = 'Success Response', int $status = 200)
    {
        return response()->json([
            'message' => $message,
            $key      => $data,
        ], $status);
    }
}

if (!function_exists('errorResponse')) {
    function errorResponse(string|array|object $error, int $status = 400)
    {
        return response()->json([
            'message' => $error,
        ], $status);
    }
}

if (! function_exists('getIamgesMediaUrl')) {
    function getIamgesMediaUrl($images, $conversions = '')
    {
        $gallery = [];
        foreach ($images as $image) {
            $gallery[] = [
                'id'  => $image->id,
                'url' => $image->getUrl($conversions),
            ];
        }

        return $gallery;
    }
}
