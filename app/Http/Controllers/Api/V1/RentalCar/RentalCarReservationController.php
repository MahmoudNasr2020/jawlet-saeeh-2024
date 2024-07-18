<?php

namespace App\Http\Controllers\Api\V1\RentalCar;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\RentalCarReservationRequest;
use App\Http\Trait\ApiTrait;
use App\Models\RentalCar;
use App\Models\RentalCarReservation;
use Carbon\Carbon;

class RentalCarReservationController extends Controller
{

    use ApiTrait;

    public function store(RentalCarReservationRequest $request)
    {

        $startDatetime = Carbon::parse($request->start_date . ' ' . $request->start_time);
        $endDatetime = Carbon::parse($request->end_date . ' ' . $request->end_time);


        // التحقق من توافر السيارة خلال الفترة المحددة
        $existingReservation = RentalCarReservation::where('rental_car_id', $request->rental_car_id)
            ->where('status',"1")
            ->where(function ($query) use ($startDatetime, $endDatetime) {
                $query->where(function ($q) use ($startDatetime, $endDatetime) {
                    $q->where('start_datetime', '>=', $startDatetime)
                        ->where('start_datetime', '<', $endDatetime);
                })->orWhere(function ($q) use ($startDatetime, $endDatetime) {
                    $q->where('end_datetime', '>', $startDatetime)
                        ->where('end_datetime', '<=', $endDatetime);
                });
            })->first();

// إذا كان هناك حجز موجود، أرجع رسالة بأن السيارة محجوزة
        if ($existingReservation) {
            return $this->response('', 'The car is already booked for this period', 409); // 409 Conflict
        }

        // جلب سعر اليوم للسيارة باستخدام rental_car_id
        $rentalCar = RentalCar::find($request->rental_car_id);

        if (!$rentalCar) {
            return $this->response('', 'Car not found', 404);
        }

        // حساب عدد الأيام بين التواريخ
        $days = $endDatetime->diffInDays($startDatetime) + 1; // +1 لضمان احتساب اليوم الأول كيوم كامل

        // حساب السعر الإجمالي عن طريق ضرب عدد الأيام في سعر اليوم للسيارة
        $totalPrice = $days * $rentalCar->price_per_day;

        // إنشاء حجز جديد مع السعر الإجمالي المحسوب
        $reservation = new RentalCarReservation([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'identity_number' => $request->identity_number,
            'license_number' => $request->license_number,
            'start_datetime' => $startDatetime,
            'end_datetime' => $endDatetime,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'total_price' => $totalPrice, // إضافة السعر الإجمالي
            'user_id' => $request->user_id,
            'rental_car_id' => $request->rental_car_id,
            'city_id' => $request->city_id,
        ]);

        $reservation->save();

        if ($reservation) {
            $reservation->load(['rentalCar' => function ($query) {
                $query->select('id', 'name', 'price_per_day');
            }]);

            // تنسيق التواريخ والأوقات بالشكل المطلوب
            $startDatetimeFormatted = $startDatetime->format('d-m-Y H:i');
            $endDatetimeFormatted = $endDatetime->format('d-m-Y H:i');

            // تحديث بيانات التواريخ بالتنسيق المطلوب
            $reservation->start_datetime = $startDatetimeFormatted;
            $reservation->end_datetime = $endDatetimeFormatted;

            return $this->response($reservation, 'Your reservation has been completed successfully', 201);
        }

        return $this->response('', 'error', 422);
    }


}
