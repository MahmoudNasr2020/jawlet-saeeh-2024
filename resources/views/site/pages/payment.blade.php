<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ app()->getLocale() == 'ar' ? settings()->site_name_ar : settings()->site_name_en }}</title>
    <link href="{{ settings()->icon }}" rel="icon" sizes="32x32" type="image/png">

    <!-- Moyasar Styles -->
    <link rel="stylesheet" href="https://cdn.moyasar.com/mpf/1.7.3/moyasar.css"/>

    <link href='https://fonts.googleapis.com/css?family=Cairo' rel='stylesheet'>

    <!-- Moyasar Scripts -->
    <script src="https://polyfill.io/v3/polyfill.min.js?features=fetch"></script>
    <script src="https://cdn.moyasar.com/mpf/1.7.3/moyasar.js"></script>
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp"></script>

    <style>
        body {
            font-family: 'Cairo', sans-serif;
            background: #f4f4f9;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .mysr-form-container {
            background: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            width: 360px;
        }

        .mysr-form-heading {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
    </style>
</head>

<body>

@php
    use Illuminate\Support\Facades\Crypt;

    $encryptedData = request('data');
    $reservationData = json_decode(Crypt::decryptString($encryptedData), true);

    // تحقق من البيانات
    if (!$reservationData) {
        abort(404);
    }
@endphp

<section class="mysr-form-container">
    <h1 class="mysr-form-heading"> {{ __('web.hello') }}
        {{ app()->getLocale() == 'ar' ? settings()->site_name_ar : settings()->site_name_en }}</h1><br>
    <div class="mysr-form"></div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        Moyasar.init({
            element: '.mysr-form',
            amount: {{ $reservationData['total_price'] * 100 }},
            currency: 'SAR',
            description: 'Hotel Reservation for {{ $reservationData['start_date'] }} to {{ $reservationData['end_date'] }}',
            publishable_api_key: "{{ moyasar_payment_settings()->status == 'live'
                    ? moyasar_payment_settings()->live_publishable_key
                    : moyasar_payment_settings()->test_publishable_key }}",
            callback_url: "{{  url('/').'/api/v1/hotel_reservations/callback' }}",
            methods: ['creditcard'],
            metadata: {
                hotel_id: "{{ $reservationData['hotel_id'] }}",
                user_id: "{{ $reservationData['user_id'] }}",
                rooms: "{{ $reservationData['rooms'] }}",
                email: "{{ $reservationData['email'] }}",
                start_date: "{{ $reservationData['start_date'] }}",
                end_date: "{{ $reservationData['end_date'] }}",
                adults: "{{ $reservationData['adults'] }}",
                children: "{{ $reservationData['children'] }}",
                total_price: "{{ $reservationData['total_price'] }}"
            },
            on_initiating: function () {
                return new Promise(function (resolve, reject) {
                    resolve({});
                });
            }
        });
    });
</script>

</body>
</html>
