<?php

namespace App\Http\Controllers\Dashboard\Hotel;

use App\Http\Controllers\Controller;
use App\Mail\ActiveHotelReservationMail;
use App\Mail\Contractmail;
use App\Models\HotelReservation;
use App\Models\RentalCarReservation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use RealRashid\SweetAlert\Facades\Alert;
use Snowfire\Beautymail\Beautymail;

class HotelReservationsController extends Controller
{
    public function current_reservations()
    {
        // الحصول على التاريخ الحالي
        $today = Carbon::now();

        // بداية الاستعلام
        $reservations = HotelReservation::with('user', 'hotel')
            ->select('*', DB::raw('DATEDIFF(end_datetime, "' . $today->toDateString() . '") as days_until_end'))
            ->where('status', "1")
            ->where('is_canceled',"0")
            ->whereDate('start_datetime', '<=', $today)
            ->whereDate('end_datetime', '>=', $today);

        $search='';
        if (request()->has('search')) {
            $search = request('search');

            // بحث داخل العلاقات
            $reservations = $reservations->where(function ($query) use ($search) {
                $query->whereHas('user', function ($query) use ($search) {
                    $query->where('first_name', 'LIKE', "%{$search}%")
                        ->orWhere('last_name', 'LIKE', "%{$search}%")
                        ->orWhere('email', 'LIKE', "%{$search}%");
                })->orWhereHas('hotel', function ($query) use ($search) {
                    $query->where('name', 'LIKE', "%{$search}%");
                });
            });
        }

        $reservations = $reservations->orderBy('days_until_end', 'asc')->paginate(10);

        $reservations->appends(['search'=>$search]);
        return view('dashboard.pages.hotels.reservations.current_reservations', compact('reservations'));
    }



    public function expired_reservations()
    {
        // الحصول على التاريخ الحالي
        $today = Carbon::now();

        $reservations = HotelReservation::with('user', 'hotel')
            ->whereDate('end_datetime', '<', $today)
            ->where('status', "1")
            ->where('is_canceled',"0");

        $search = '';
        if (request()->has('search')) {
            $search = request('search');

            // بحث داخل العلاقات
            $reservations = $reservations->where(function ($query) use ($search) {
                $query->whereHas('user', function ($query) use ($search) {
                    $query->where('first_name', 'LIKE', "%{$search}%")
                        ->orWhere('last_name', 'LIKE', "%{$search}%")
                        ->orWhere('email', 'LIKE', "%{$search}%");
                })->orWhereHas('hotel', function ($query) use ($search) {
                    $query->where('name', 'LIKE', "%{$search}%");
                });
            });
        }

        $reservations = $reservations->orderBy('id', 'desc')->paginate(10);
        $reservations->appends(['search'=>$search]);

        return view('dashboard.pages.hotels.reservations.expired_reservations', compact('reservations'));
    }


    public function upcoming_reservations()
    {
        // الحصول على التاريخ الحالي
        $today = Carbon::now();

        $reservations = HotelReservation::with('user', 'hotel')
            ->whereDate('start_datetime', '>', $today)
            ->where('status', "1")
            ->where('is_canceled',"0");

        $search = '';
        if (request()->has('search')) {
            $search = request('search');

            // بحث داخل العلاقات
            $reservations = $reservations->where(function ($query) use ($search) {
                $query->whereHas('user', function ($query) use ($search) {
                    $query->where('first_name', 'LIKE', "%{$search}%")
                        ->orWhere('last_name', 'LIKE', "%{$search}%")
                        ->orWhere('email', 'LIKE', "%{$search}%");
                })->orWhereHas('hotel', function ($query) use ($search) {
                    $query->where('name', 'LIKE', "%{$search}%");
                });
            });
        }

        $reservations = $reservations->orderBy('id', 'desc')->paginate(10);

        $reservations->appends(['search'=>$search]);

        return view('dashboard.pages.hotels.reservations.upcoming_reservations', compact('reservations'));
    }


    public function expected_reservations()
    {
        // الحصول على التاريخ الحالي
        $today = Carbon::now();

        $reservations = HotelReservation::with('user:id,first_name,last_name,email', 'hotel:id,name,main_image,location')
            ->where('status', "0")
            ->where('is_canceled',"0");

        // إضافة شروط البحث إذا توفرت
        $search='';
        if (request()->has('search')) {
            $search = request('search');

            // بحث داخل العلاقات
            $reservations = $reservations->where(function ($query) use ($search) {
                $query->whereHas('user', function ($query) use ($search) {
                    $query->where('first_name', 'LIKE', "%{$search}%")
                        ->orWhere('last_name', 'LIKE', "%{$search}%")
                        ->orWhere('email', 'LIKE', "%{$search}%");
                })->orWhereHas('hotel', function ($query) use ($search) {
                    $query->where('name', 'LIKE', "%{$search}%");
                });
            });

        }

        $reservations = $reservations->orderBy('start_datetime', 'asc')->paginate(10);
        $reservations->appends(['search'=>$search]);
        // عرض الحجوزات المقبلة في الواجهة
        return view('dashboard.pages.hotels.reservations.expected_reservations', compact('reservations'));
    }

    public function canceled_reservations()
    {
        $today = Carbon::now();

        $reservations = HotelReservation::with('user:id,first_name,last_name,email', 'hotel:id,name,main_image,location')
            ->where('is_canceled',"1");

        // إضافة شروط البحث إذا توفرت
        $search='';
        if (request()->has('search')) {
            $search = request('search');

            // بحث داخل العلاقات
            $reservations = $reservations->where(function ($query) use ($search) {
                $query->whereHas('user', function ($query) use ($search) {
                    $query->where('first_name', 'LIKE', "%{$search}%")
                        ->orWhere('last_name', 'LIKE', "%{$search}%")
                        ->orWhere('email', 'LIKE', "%{$search}%");
                })->orWhereHas('hotel', function ($query) use ($search) {
                    $query->where('name', 'LIKE', "%{$search}%");
                });
            });

        }

        $reservations = $reservations->orderBy('id', 'desc')->paginate(10);
        $reservations->appends(['search'=>$search]);
        return view('dashboard.pages.hotels.reservations.canceled_reservations', compact('reservations'));
    }


    public function show($id)
    {
        $reservation = HotelReservation::with('user','hotel')->findOrFail($id);
        return view('dashboard.pages.hotels.reservations.show', compact('reservation'));
    }

    public function destroy($id)
    {
        HotelReservation::findOrFail($id)->delete();
        return 'done';
    }



    public function active_reservation(Request $request)
    {
        $reservation = HotelReservation::findOrFail($request->reservationId);
        try
        {

            $beautymail = app()->make(Beautymail::class);
            $beautymail->send('mail.ActiveHotelReservationMail',  ['reservation' => $reservation], function($message) use($request,$reservation)
            {
                $message
                    //->from($request->email)
                    ->to($reservation->email)
                    ->subject(settings()->site_name_ar);
            });
            //Mail::to($reservation->email)->send(new ActiveHotelReservationMail($reservation));
            $reservation->update(['status' => "1"]);
            Alert::success('Success', 'تم تفعيل الحجز وارسال تنبيه للعميل بنجاح');
            return back();
        }
        catch (\Exception $e) {

            Alert::success('error', 'خطا في تفعيل الحجز');
            return back();
        }


    }

    public function cancel_reservation(Request $request)
    {
        $reservation = HotelReservation::findOrFail($request->reservationId);
        try
        {

            $beautymail = app()->make(Beautymail::class);
            $beautymail->send('mail.CancelHotelReservationMail',  ['reservation' => $reservation], function($message) use($request,$reservation)
            {
                $message
                    //->from($request->email)
                    ->to($reservation->email)
                    ->subject(settings()->site_name_ar);
            });
            //Mail::to($reservation->email)->send(new ActiveHotelReservationMail($reservation));
            $reservation->update(['is_canceled' => "1"]);
            Alert::success('Success', 'تم الغاء الحجز وارسال تنبيه للعميل بنجاح');
            return back();
        }
        catch (\Exception $e) {

            Alert::success('error', 'خطا في الغاء الحجز');
            return back();
        }


    }


    /*public function markAsViewed(Request $request)
    {

        RentalCarReservation::orderBy('id','desc')
            ->update(['is_viewed' => 1]);

        return response()->json(['success' => true]);
    }*/
}
