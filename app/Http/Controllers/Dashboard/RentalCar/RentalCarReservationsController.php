<?php

namespace App\Http\Controllers\Dashboard\RentalCar;

use App\Http\Controllers\Controller;
use App\Mail\Contractmail;
use App\Models\City;
use App\Models\RentalCarReservation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use RealRashid\SweetAlert\Facades\Alert;

class RentalCarReservationsController extends Controller
{

    public function current_reservations()
    {
        // الحصول على التاريخ الحالي
        $today = Carbon::now();

        // بداية الاستعلام
        $reservations = RentalCarReservation::with('user', 'rentalCar', 'city')
            ->select('*', DB::raw('DATEDIFF(end_datetime, "' . $today->toDateString() . '") as days_until_end'))
            ->where('status', "1")
            ->whereDate('start_datetime', '<=', $today)
            ->whereDate('end_datetime', '>=', $today);

        // إضافة شروط البحث إذا توفرت
        if (request()->has('search')) {
            $search = request('search');

            // بحث داخل العلاقات
            $reservations = $reservations->where(function ($query) use ($search) {
                $query->whereHas('user', function ($query) use ($search) {
                    $query->where('first_name', 'LIKE', "%{$search}%")
                        ->orWhere('last_name', 'LIKE', "%{$search}%")
                        ->orWhere('email', 'LIKE', "%{$search}%");
                })->orWhereHas('rentalCar', function ($query) use ($search) {
                    $query->where('name', 'LIKE', "%{$search}%");
                })->orWhereHas('city', function ($query) use ($search) {
                    $query->where('name', 'LIKE', "%{$search}%");
                });
            });
        }

        // استكمال الاستعلام وترتيب النتائج وتقسيم الصفحات
        $reservations = $reservations->orderBy('days_until_end', 'asc')->paginate(10);

        return view('dashboard.pages.rental_car.reservations.current_reservations', compact('reservations'));
    }



    public function expired_reservations()
    {
        // الحصول على التاريخ الحالي
        $today = Carbon::now();

        $reservations = RentalCarReservation::with('user', 'rentalCar', 'city')
            ->whereDate('end_datetime', '<', $today)
            ->where('status', "1");

        // إضافة شروط البحث إذا توفرت
        if (request()->has('search')) {
            $search = request('search');

            // بحث داخل العلاقات
            $reservations = $reservations->where(function ($query) use ($search) {
                $query->whereHas('user', function ($query) use ($search) {
                    $query->where('first_name', 'LIKE', "%{$search}%")
                        ->orWhere('last_name', 'LIKE', "%{$search}%")
                        ->orWhere('email', 'LIKE', "%{$search}%");
                })->orWhereHas('rentalCar', function ($query) use ($search) {
                    $query->where('name', 'LIKE', "%{$search}%");
                })->orWhereHas('city', function ($query) use ($search) {
                    $query->where('name', 'LIKE', "%{$search}%");
                });
            });
        }

        $reservations = $reservations->orderBy('id', 'desc')->paginate(10);

        // عرض الحجوزات المنتهية في الواجهة
        return view('dashboard.pages.rental_car.reservations.expired_reservations', compact('reservations'));
    }


    public function upcoming_reservations()
    {
        // الحصول على التاريخ الحالي
        $today = Carbon::now();

        $reservations = RentalCarReservation::with('user', 'rentalCar', 'city')
            ->whereDate('start_datetime', '>', $today)
            ->where('status', "1");

        // إضافة شروط البحث إذا توفرت
        if (request()->has('search')) {
            $search = request('search');

            // بحث داخل العلاقات
            $reservations = $reservations->where(function ($query) use ($search) {
                $query->whereHas('user', function ($query) use ($search) {
                    $query->where('first_name', 'LIKE', "%{$search}%")
                        ->orWhere('last_name', 'LIKE', "%{$search}%")
                        ->orWhere('email', 'LIKE', "%{$search}%");
                })->orWhereHas('rentalCar', function ($query) use ($search) {
                    $query->where('name', 'LIKE', "%{$search}%");
                })->orWhereHas('city', function ($query) use ($search) {
                    $query->where('name', 'LIKE', "%{$search}%");
                });
            });
        }

        $reservations = $reservations->orderBy('id', 'desc')->paginate(10);

        // عرض الحجوزات المقبلة في الواجهة
        return view('dashboard.pages.rental_car.reservations.upcoming_reservations', compact('reservations'));
    }


    public function expected_reservations()
    {
        // الحصول على التاريخ الحالي
        $today = Carbon::now();

        $reservations = RentalCarReservation::with('user', 'rentalCar', 'city')
            ->where('status', "0");

        // إضافة شروط البحث إذا توفرت
        if (request()->has('search')) {
            $search = request('search');

            // بحث داخل العلاقات
            $reservations = $reservations->where(function ($query) use ($search) {
                $query->whereHas('user', function ($query) use ($search) {
                    $query->where('first_name', 'LIKE', "%{$search}%")
                        ->orWhere('last_name', 'LIKE', "%{$search}%")
                        ->orWhere('email', 'LIKE', "%{$search}%");
                })->orWhereHas('rentalCar', function ($query) use ($search) {
                    $query->where('name', 'LIKE', "%{$search}%");
                })->orWhereHas('city', function ($query) use ($search) {
                    $query->where('name', 'LIKE', "%{$search}%");
                });
            });
        }

        $reservations = $reservations->orderBy('start_datetime', 'asc')->paginate(10);

        // عرض الحجوزات المقبلة في الواجهة
        return view('dashboard.pages.rental_car.reservations.expected_reservations', compact('reservations'));
    }



    public function show($id)
    {
        $reservation = RentalCarReservation::with('user','rentalCar','city')->findOrFail($id);

        $today = Carbon::now();
        // فلترة الحجوزات الحالية
        $currentReservations = $reservation->rentalCar->reservations->filter(function ($reservation) use ($today) {
            return $reservation->status == "1" && $reservation->start_datetime <= $today && $reservation->end_datetime >= $today;
        });

        // فلترة الحجوزات المقبلة
        $upcomingReservations =  $reservation->rentalCar->reservations->filter(function ($reservation) use ($today) {
            return  $reservation->status == "1" && $reservation->start_datetime > $today;
        });

        // فلترة الحجوزات المنتهية
        $pastReservations =  $reservation->rentalCar->reservations->filter(function ($reservation) use ($today) {
            return  $reservation->status == "1" && $reservation->end_datetime < $today;
        });

        return view('dashboard.pages.rental_car.reservations.show', compact('reservation','currentReservations','upcomingReservations','pastReservations'));
    }

    public function destroy($id)
    {
        RentalCarReservation::findOrFail($id)->delete();
        return 'done';
    }


    public function send_contract(Request $request)
    {

         $reservation = RentalCarReservation::findOrFail($request->reservationId);

        try {
            Mail::to($reservation->email)->send(new Contractmail($reservation));
            $reservation->update(['contract_status' => "1"]);
            Alert::success('Success', 'تم ارسال العقد بنجاح');
            return back();
        }
        catch (\Exception $e) {

            Alert::success('error', 'خطا في ارسال العقد');
            return back();
        }
    }

    public function active_reservation(Request $request)
    {
        $reservation = RentalCarReservation::findOrFail($request->reservationId);
        $start_datetime = $reservation->start_datetime;
        $end_datetime = $reservation->end_datetime;

        // البحث عن حجوزات أخرى تتداخل مع الفترة الزمنية للحجز الذي نريد تفعيله
        $overlappingReservations = RentalCarReservation::with('user:id,first_name,last_name')->where('id', '!=', $reservation->id) // استبعاد الحجز الحالي من البحث
            ->where('status','1')
        ->where(function ($query) use ($start_datetime, $end_datetime) {
            $query->whereBetween('start_datetime', [$start_datetime, $end_datetime])
                ->orWhereBetween('end_datetime', [$start_datetime, $end_datetime])
                ->orWhere(function ($query) use ($start_datetime, $end_datetime) {
                    $query->where('start_datetime', '<', $start_datetime)
                        ->where('end_datetime', '>', $end_datetime);
                });
        })
            ->first();

        if ($overlappingReservations) {
            // إذا وُجد تداخل، قم بإرجاع رسالة خطأ مع اسم الحجز المتداخل
             $reservationName = $overlappingReservations->user->first_name.' ' .$overlappingReservations->user->last_name; // افتراض أن العمود الذي يحتوي على اسم الحجز يُسمى 'name'
            Alert::error('Error', "يوجد حجز آخر مفعل للسيارة يتداخل مع هذه الفترة. اسم العميل: {$reservationName}");
            return back();
        }

        // إذا لم يوجد تداخل، قم بتفعيل الحجز
        $reservation->update(['status' => "1"]);
        Alert::success('Success', 'تم تفعيل الحجز بنجاح');
        return back();
    }


  /*  public function getNewNotifications(Request $request)
    {
         $lastId = $request->input('lastId', 0);

        $newNotifications = \App\Models\RentalCarReservation::where('is_viewed', 0)
            ->where('id', '>', $lastId)
            ->with('user:id,first_name,last_name', 'rentalCar:id,name')
            ->orderBy('id', 'desc') // تأكد من ترتيب النتائج بحيث تأتي الأحدث أولاً
            ->get()
            ->map(function ($notification) {
                $notification->created_at_human = $notification->created_at->diffForHumans();
                return $notification;
            });

        return response()->json(['notifications' => $newNotifications]);
    }

*/

    public function markAsViewed(Request $request)
    {

        RentalCarReservation::orderBy('id','desc')
            ->update(['is_viewed' => 1]);

        return response()->json(['success' => true]);
    }

}
