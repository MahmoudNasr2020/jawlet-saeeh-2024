<?php

namespace App\Services;

use App\Models\HotelReservation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use RealRashid\SweetAlert\Facades\Alert;

class MoyasarService
{
    public function makePayment($card_data, $reservationData)
    {
        $response = Http::withHeaders([
            'Authorization' => moyasar_payment_settings()->status == 'live'
                ? moyasar_payment_settings()->live_secret_key : moyasar_payment_settings()->test_secret_key
         ])->post('https://api.moyasar.com/v1/payments', [
            'amount' => $reservationData['total_price'] * 100,
            'currency' => 'SAR',
            'description' => 'Reservation for hotel',
            'metadata' => $reservationData,
            'source' => [
                'type' => 'creditcard',
                'name' => $card_data['card_customer_name'],
                'number'=> $card_data['card_number'],
                'cvc' => $card_data['card_cvc'],
                'month' => $card_data['card_month'],
                'year' =>  $card_data['card_year'],
            ],
            'publishable_api_key' => moyasar_payment_settings()->status == 'live'
                ? moyasar_payment_settings()->live_publishable_key : moyasar_payment_settings()->test_publishable_key,
            'callback_url' => url('/').'/api/v1/hotel_reservations/callback',
        ]);

        return $response->json()['source']['transaction_url'];
    }

    public function saveReservation($payment)
    {
        $reservationData = $payment['metadata'];

        return HotelReservation::create([
            'user_id' => $reservationData['user_id'],
            'hotel_id' => $reservationData['hotel_id'],
            'rooms' => $reservationData['rooms'],
            'total_price' => $reservationData['total_price'],
            'start_datetime' => Carbon::parse($reservationData['start_date']),
            'end_datetime' => Carbon::parse($reservationData['end_date']),
            'email' => $reservationData['email'],
            'number_of_persons' => json_encode([
                'adults' => $reservationData['adults'],
                'children' => $reservationData['children']
            ]),
        ]);
    }

    public function handleCallback($request)
    {
        $id = $request->id;
        $token = moyasar_payment_settings()->status == 'live'
            ? moyasar_payment_settings()->live_secret_key : moyasar_payment_settings()->test_secret_key;

        $token = base64_encode($token.':');

         $payment = Http::baseUrl('https://api.moyasar.com/v1/')
            ->withHeaders([
                'Authorization' => "Basic {$token}"
            ])
            ->get('payments/'.$id)
            ->json();

        switch ($payment['status']) {
            case 'authorized':
                $capture = Http::baseUrl('https://api.moyasar.com/v1/')
                    ->withHeaders([
                        'Authorization' => "Basic {$token}"
                    ])
                    ->post('payments/'.$id.'/capture')
                    ->json();

                if ($capture['status'] === 'captured') {
                    $this->saveReservation($payment);
                    return redirect()->route('site.payment-success');
                }

                else {
                    return redirect()->route('site.payment-failed');
                }

            case 'paid':
                $this->saveReservation($payment);
                return redirect()->route('site.payment-success');


            case 'failed':
                return redirect()->route('site.payment-failed');

            case 'pending':
                return redirect()->route('site.payment-failed');

            default:
                return redirect()->route('site.payment-failed');
        }
    }

    /*public function handleCallback($request)
    {
        $id = $request->id;
        $token = base64_encode('sk_test_GRBEVi2Wi8W8uWoYhC85DhQwTVSEfmWxsEo6q9iP:');
        $payment = Http::baseUrl('https://api.moyasar.com/v1/')
            ->withHeaders([
                'Authorization' => "Basic {$token}"
            ])
            ->get('payments/'.$id)
            ->json();

        switch ($payment['status']) {
            case 'authorized':
                $capture = Http::baseUrl('https://api.moyasar.com/v1/')
                    ->withHeaders([
                        'Authorization' => "Basic {$token}"
                    ])
                    ->post('payments/'.$id.'/capture')
                    ->json();

                if ($capture['status'] === 'captured') {
                    $this->saveReservation($payment);
                    return response()->json(['message' => 'Payment captured successfully', 'data' => $capture], 200);
                } else {
                    return response()->json(['message' => 'Failed to capture payment', 'data' => $capture], 500);
                }

            case 'paid':
                $this->saveReservation($payment);
                return response()->json(['message' => 'Payment already captured', 'data' => $payment], 200);

            case 'failed':
                return response()->json(['message' => 'Payment failed', 'data' => $payment], 400);

            case 'pending':
                return response()->json(['message' => 'Payment is still pending', 'data' => $payment], 202);

            default:
                return response()->json(['message' => 'Payment status unknown', 'data' => $payment], 500);
        }
    }*/



}
