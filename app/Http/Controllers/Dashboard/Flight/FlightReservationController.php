<?php

namespace App\Http\Controllers\Dashboard\Flight;

use App\Http\Controllers\Controller;
use App\Models\FlightReservation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Snowfire\Beautymail\Beautymail;

class FlightReservationController extends Controller
{
    public function current_reservations()
    {
        // الحصول على التاريخ الحالي
        $today = Carbon::now();

        // بداية الاستعلام
        $reservations = FlightReservation::with('user', 'fromAirport','toAirport')
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
                })
                    ->orWhereHas('fromAirport', function ($query) use ($search) {
                        $query->where('name_ar', 'LIKE', "%{$search}%")
                            ->orWhere('name_en', 'LIKE', "%{$search}%");
                    })
                    ->orWhereHas('toAirport', function ($query) use ($search) {
                        $query->where('name_ar', 'LIKE', "%{$search}%")
                            ->orWhere('name_en', 'LIKE', "%{$search}%");
                    });

            });
        }

        $reservations = $reservations->orderBy('days_until_end', 'asc')->paginate(10);

        $reservations->appends(['search'=>$search]);
        return view('dashboard.pages.flight.reservations.current_reservations', compact('reservations'));
    }



    public function expired_reservations()
    {
        // الحصول على التاريخ الحالي
        $today = Carbon::now();

        $reservations = FlightReservation::with('user', 'fromAirport','toAirport')
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
                })
                    ->orWhereHas('fromAirport', function ($query) use ($search) {
                        $query->where('name_ar', 'LIKE', "%{$search}%")
                            ->orWhere('name_en', 'LIKE', "%{$search}%");
                    })
                    ->orWhereHas('toAirport', function ($query) use ($search) {
                        $query->where('name_ar', 'LIKE', "%{$search}%")
                            ->orWhere('name_en', 'LIKE', "%{$search}%");
                    });

            });
        }

        $reservations = $reservations->orderBy('id', 'desc')->paginate(10);
        $reservations->appends(['search'=>$search]);

        return view('dashboard.pages.flight.reservations.expired_reservations', compact('reservations'));
    }


    public function upcoming_reservations()
    {
        // الحصول على التاريخ الحالي
        $today = Carbon::now();

        $reservations = FlightReservation::with('user', 'fromAirport','toAirport')
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
                        ->orWhere('phone', 'LIKE', "%{$search}%");
                })
                    ->orWhereHas('fromAirport', function ($query) use ($search) {
                        $query->where('name_ar', 'LIKE', "%{$search}%")
                            ->orWhere('name_en', 'LIKE', "%{$search}%");
                    })
                    ->orWhereHas('toAirport', function ($query) use ($search) {
                        $query->where('name_ar', 'LIKE', "%{$search}%")
                            ->orWhere('name_en', 'LIKE', "%{$search}%");
                    });

            });
        }

        $reservations = $reservations->orderBy('id', 'desc')->paginate(10);

        $reservations->appends(['search'=>$search]);

        return view('dashboard.pages.flight.reservations.upcoming_reservations', compact('reservations'));
    }


    public function expected_reservations()
    {
        // الحصول على التاريخ الحالي
        $today = Carbon::now();

        $reservations = FlightReservation::with('user:id,first_name,last_name,email,phone', 'fromAirport:id,name_ar,name_en', 'toAirport:id,name_ar,name_en')
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
                })
                    ->orWhereHas('fromAirport', function ($query) use ($search) {
                        $query->where('name_ar', 'LIKE', "%{$search}%")
                            ->orWhere('name_en', 'LIKE', "%{$search}%");
                    })
                    ->orWhereHas('toAirport', function ($query) use ($search) {
                        $query->where('name_ar', 'LIKE', "%{$search}%")
                            ->orWhere('name_en', 'LIKE', "%{$search}%");
                    });

            });
        }

        $reservations = $reservations->orderBy('start_datetime', 'asc')->paginate(10);
        $reservations->appends(['search'=>$search]);
        // عرض الحجوزات المقبلة في الواجهة
        return view('dashboard.pages.flight.reservations.expected_reservations', compact('reservations'));
    }

    public function canceled_reservations()
    {
        $today = Carbon::now();

        $reservations = FlightReservation::with('user:id,first_name,last_name,email,phone', 'fromAirport:id,name_ar,name_en', 'toAirport:id,name_ar,name_en')
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
                })
                    ->orWhereHas('fromAirport', function ($query) use ($search) {
                        $query->where('name_ar', 'LIKE', "%{$search}%")
                            ->orWhere('name_en', 'LIKE', "%{$search}%");
                    })
                    ->orWhereHas('toAirport', function ($query) use ($search) {
                        $query->where('name_ar', 'LIKE', "%{$search}%")
                            ->orWhere('name_en', 'LIKE', "%{$search}%");
                    });

            });
        }

        $reservations = $reservations->orderBy('id', 'desc')->paginate(10);
        $reservations->appends(['search'=>$search]);
        return view('dashboard.pages.flight.reservations.canceled_reservations', compact('reservations'));
    }


    public function show($id)
    {
        $reservation = FlightReservation::with('user','fromAirport', 'toAirport')->findOrFail($id);
        return view('dashboard.pages.flight.reservations.show', compact('reservation'));
    }

    public function destroy($id)
    {
        FlightReservation::findOrFail($id)->delete();
        return 'done';
    }


    public function active_reservation(Request $request)
    {
        $reservation = FlightReservation::findOrFail($request->reservationId);
        try
        {
            $reservation->update(['status' => "1"]);
            Alert::success('Success', 'تم تفعيل الحجز');
            return back();
        }
        catch (\Exception $e) {

            Alert::success('error', 'خطا في تفعيل الحجز');
            return back();
        }


    }

    public function cancel_reservation(Request $request)
    {
        $reservation = FlightReservation::findOrFail($request->reservationId);
        try
        {
            $reservation->update(['is_canceled' => "1"]);
            Alert::success('Success', 'تم الغاء الحجز بنجاح');
            return back();
        }
        catch (\Exception $e) {

            Alert::success('error', 'خطا في الغاء الحجز');
            return back();
        }
    }



    public function overview()
    {

        $mostBookedAirports = FlightReservation::query()
            ->select(DB::raw('MIN(id) as id'), 'to_airport_id', DB::raw('count(*) as total_reservations'))
            ->groupBy('to_airport_id')
            ->orderBy('total_reservations', 'desc')
            ->with('toAirport:id,name_ar,name_en,region_ar,region_en,country_name_en,country_name_ar')
            ->take(9)
            ->get();


        $today = Carbon::now();

        $upcomingBookings = FlightReservation::where('status', "1")
            ->where('start_datetime', '>', $today)
            ->get();

        $currentBookings = FlightReservation::where('status', "1")
            ->where('start_datetime', '<=', $today)
            ->where('end_datetime', '>=', $today)
            ->get();

        $pendingBookings = FlightReservation::where('status', "0")
            ->get();

        $finishedBookings = FlightReservation::where('status', "1")
            ->where('end_datetime', '<', $today)
            ->get();


        $bookings = FlightReservation::select(
            DB::raw('MONTH(start_datetime) as month'),
            DB::raw('count(*) as bookings_count')
        )
            // ->where('is_canceled', '0')
            ->groupBy('month')
            ->get();

        $months = [
            'January', 'February', 'March',
            'April', 'May', 'June',
            'July', 'August', 'September',
            'October', 'November', 'December'
        ];

        $bookingsData = array_fill(0, count($months), 0);

        foreach ($bookings as $booking) {
            $bookingsData[$booking->month - 1] = $booking->bookings_count;
        }

        $chartjs = app()->chartjs
            ->name('lineChartTest')
            ->type('line')
            ->size(['width' => 400, 'height' => 200])
            ->labels($months)
            ->datasets([
                [
                    "label" => "الحجوزات",
                    'backgroundColor' => "rgba(38, 185, 154, 0.31)",
                    'borderColor' => "rgba(38, 185, 154, 0.7)",
                    "pointBorderColor" => "rgba(38, 185, 154, 0.7)",
                    "pointBackgroundColor" => "rgba(38, 185, 154, 0.7)",
                    "pointHoverBackgroundColor" => "#fff",
                    "pointHoverBorderColor" => "rgba(220,220,220,1)",
                    "data" => $bookingsData,
                    "fill" => false,
                ]
            ])
            ->options([]);



        $bookingsDataByType = [
            'upcoming' => $upcomingBookings,
            'current' => $currentBookings,
            'pending' => $pendingBookings,
            'finished' => $finishedBookings,
        ];

        $bookingsCountByMonthAndType = [];
        foreach ($bookingsDataByType as $type => $bookings) {
            $counts = [];
            foreach ($bookings as $booking) {
                $month = Carbon::parse($booking->start_datetime)->format('F');
                if (!isset($counts[$month])) {
                    $counts[$month] = 0;
                }
                $counts[$month]++;
            }
            $bookingsCountByMonthAndType[$type] = $counts;
        }


        $datasets = [];
        foreach ($months as $month) {
            foreach (['upcoming', 'current', 'pending', 'finished'] as $type) {
                $datasets[$type][] = $bookingsCountByMonthAndType[$type][$month] ?? 0;
            }
        }


        $chartjsBar = app()->chartjs
            ->name('barChartTest')
            ->type('bar')
            ->size(['width' => 400, 'height' => 200])
            ->labels($months)
            ->datasets([
                [
                    "label" => "حجوزات مقبلة",
                    'backgroundColor' => '#495057',
                    'data' => $datasets['upcoming']
                ],
                [
                    "label" => "حجوزات حالية",
                    'backgroundColor' => '#3bc0c3',
                    'data' => $datasets['current']
                ],
                [
                    "label" => "حجوزات معلقة",
                    'backgroundColor' => '#4a8d73',
                    'data' => $datasets['pending']
                ],
                [
                    "label" => "حجوزات منتهية",
                    'backgroundColor' => '#d03f3f',
                    'data' => $datasets['finished']
                ]
            ])
            ->options([
                "scales" => [
                    "y" => [
                        "beginAtZero" => true
                    ]
                ]
            ]);




        $canceledBookings = FlightReservation::select(
            DB::raw('MONTH(start_datetime) as month'),
            DB::raw('count(*) as count')
        )
            ->where('is_canceled', "1")
            ->groupBy('month')
            ->get()
            ->pluck('count', 'month')
            ->toArray();


        $notCanceledBookings = FlightReservation::select(
            DB::raw('MONTH(start_datetime) as month'),
            DB::raw('count(*) as count')
        )
            ->where('is_canceled', "0")
            ->groupBy('month')
            ->get()
            ->pluck('count', 'month')
            ->toArray();


        $datasetsCanceled = array_fill(0, 12, 0);
        $datasetsNotCanceled = array_fill(0, 12, 0);

        foreach ($canceledBookings as $month => $count) {
            $datasetsCanceled[$month - 1] = $count;
        }

        foreach ($notCanceledBookings as $month => $count) {
            $datasetsNotCanceled[$month - 1] = $count;
        }


        $chartjs_reservation = app()->chartjs
            ->name('bookingsCancellationChart')
            ->type('line')
            ->size(['width' => 400, 'height' => 200])
            ->labels($months)
            ->datasets([
                [
                    "label" => "الحجوزات الملغية",
                    'backgroundColor' => "rgba(255, 99, 132, 0.2)",
                    'borderColor' => "rgba(255, 99, 132, 1)",
                    'data' => $datasetsCanceled,
                    'fill' => false,
                ],
                [
                    "label" => "الحجوزات الغير ملغية",
                    'backgroundColor' => "rgba(54, 162, 235, 0.2)",
                    'borderColor' => "rgba(54, 162, 235, 1)",
                    'data' => $datasetsNotCanceled,
                    'fill' => false,
                ]
            ])
            ->options([]);

        return view('dashboard.pages.flight.overview',compact('chartjs','chartjsBar','chartjs_reservation','mostBookedAirports'));
    }
}
