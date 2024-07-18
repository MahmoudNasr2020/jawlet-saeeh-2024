<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\FlightReservation;
use App\Models\HotelReservation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {

        $chartjs = $this->hotelOverview()['chartjs'];
        $chartjsBar = $this->hotelOverview()['chartjsBar'];
        $chartjs_reservation = $this->hotelOverview()['chartjs_reservation'];
        $mostBookedHotels = $this->hotelOverview()['mostBookedHotels'];

        $flightChartjs = $this->flightOverview()['flightChartjs'];
        $flightChartjsBar = $this->flightOverview()['flightChartjsBar'];
        $flightMostBookedAirports = $this->flightOverview()['flightMostBookedAirports'];

        return view('dashboard.pages.home',compact('chartjs','chartjsBar'
            ,'chartjs_reservation','mostBookedHotels','flightChartjs','flightChartjsBar','flightMostBookedAirports'));
    }



    public function hotelOverview()
    {
        $mostBookedHotels = HotelReservation::query()
            ->select('hotel_id', DB::raw('count(*) as total_reservations'))
            ->groupBy('hotel_id')
            ->orderBy('total_reservations', 'desc')
            ->with('hotel:id,name,main_image,description')
            ->take(9)
            ->get();

        $today = Carbon::now();

        $upcomingBookings = HotelReservation::where('status', "1")
            ->where('start_datetime', '>', $today)
            ->get();

        $currentBookings = HotelReservation::where('status', "1")
            ->where('start_datetime', '<=', $today)
            ->where('end_datetime', '>=', $today)
            ->get();

        $pendingBookings = HotelReservation::where('status', "0")
            ->get();

        $finishedBookings = HotelReservation::where('status', "1")
            ->where('end_datetime', '<', $today)
            ->get();


        $bookings = HotelReservation::select(
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




        $canceledBookings = HotelReservation::select(
            DB::raw('MONTH(start_datetime) as month'),
            DB::raw('count(*) as count')
        )
            ->where('is_canceled', "1")
            ->groupBy('month')
            ->get()
            ->pluck('count', 'month')
            ->toArray();


        $notCanceledBookings = HotelReservation::select(
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

        return [
            'chartjs' => $chartjs,
            'chartjsBar' => $chartjsBar,
            'chartjs_reservation' => $chartjs_reservation,
            'mostBookedHotels' => $mostBookedHotels
        ];
    }



    public function flightOverview()
    {
        $flightMostBookedAirports = FlightReservation::query()
            ->select(DB::raw('MIN(id) as id'), 'to_airport_id', DB::raw('count(*) as total_reservations'))
            ->groupBy('to_airport_id')
            ->orderBy('total_reservations', 'desc')
            ->with('toAirport:id,name_ar,name_en,region_ar,region_en,country_name_en,country_name_ar')
            ->take(9)
            ->get();

        $flightToday = Carbon::now();

        $flightUpcomingBookings = FlightReservation::where('status', "1")
            ->where('start_datetime', '>', $flightToday)
            ->get();

        $flightCurrentBookings = FlightReservation::where('status', "1")
            ->where('start_datetime', '<=', $flightToday)
            ->where('end_datetime', '>=', $flightToday)
            ->get();

        $flightPendingBookings = FlightReservation::where('status', "0")
            ->get();

        $flightFinishedBookings = FlightReservation::where('status', "1")
            ->where('end_datetime', '<', $flightToday)
            ->get();

        $flightBookings = FlightReservation::select(
            DB::raw('MONTH(start_datetime) as month'),
            DB::raw('count(*) as bookings_count')
        )
            ->groupBy('month')
            ->get();

        $flightMonths = [
            'January', 'February', 'March',
            'April', 'May', 'June',
            'July', 'August', 'September',
            'October', 'November', 'December'
        ];

        $flightBookingsData = array_fill(0, count($flightMonths), 0);

        foreach ($flightBookings as $booking) {
            $flightBookingsData[$booking->month - 1] = $booking->bookings_count;
        }

        $flightChartjs = app()->chartjs
            ->name('flightLineChartTest')
            ->type('line')
            ->size(['width' => 400, 'height' => 200])
            ->labels($flightMonths)
            ->datasets([
                [
                    "label" => "الحجوزات",
                    'backgroundColor' => "rgba(38, 185, 154, 0.31)",
                    'borderColor' => "rgba(38, 185, 154, 0.7)",
                    "pointBorderColor" => "rgba(38, 185, 154, 0.7)",
                    "pointBackgroundColor" => "rgba(38, 185, 154, 0.7)",
                    "pointHoverBackgroundColor" => "#fff",
                    "pointHoverBorderColor" => "rgba(220,220,220,1)",
                    "data" => $flightBookingsData,
                    "fill" => false,
                ]
            ])
            ->options([]);

        $flightBookingsDataByType = [
            'upcoming' => $flightUpcomingBookings,
            'current' => $flightCurrentBookings,
            'pending' => $flightPendingBookings,
            'finished' => $flightFinishedBookings,
        ];

        $flightBookingsCountByMonthAndType = [];
        foreach ($flightBookingsDataByType as $type => $bookings) {
            $counts = [];
            foreach ($bookings as $booking) {
                $month = Carbon::parse($booking->start_datetime)->format('F');
                if (!isset($counts[$month])) {
                    $counts[$month] = 0;
                }
                $counts[$month]++;
            }
            $flightBookingsCountByMonthAndType[$type] = $counts;
        }

        $flightDatasets = [];
        foreach ($flightMonths as $month) {
            foreach (['upcoming', 'current', 'pending', 'finished'] as $type) {
                $flightDatasets[$type][] = $flightBookingsCountByMonthAndType[$type][$month] ?? 0;
            }
        }

        $flightChartjsBar = app()->chartjs
            ->name('flightBarChartTest')
            ->type('bar')
            ->size(['width' => 400, 'height' => 200])
            ->labels($flightMonths)
            ->datasets([
                [
                    "label" => "حجوزات مقبلة",
                    'backgroundColor' => '#495057',
                    'data' => $flightDatasets['upcoming']
                ],
                [
                    "label" => "حجوزات حالية",
                    'backgroundColor' => '#3bc0c3',
                    'data' => $flightDatasets['current']
                ],
                [
                    "label" => "حجوزات معلقة",
                    'backgroundColor' => '#4a8d73',
                    'data' => $flightDatasets['pending']
                ],
                [
                    "label" => "حجوزات منتهية",
                    'backgroundColor' => '#d03f3f',
                    'data' => $flightDatasets['finished']
                ]
            ])
            ->options([
                "scales" => [
                    "y" => [
                        "beginAtZero" => true
                    ]
                ]
            ]);

        return [
            'flightChartjs' => $flightChartjs,
            'flightChartjsBar' => $flightChartjsBar,
            'flightMostBookedAirports' => $flightMostBookedAirports
        ];
       // return view('dashboard.pages.flight.overview', compact('flightChartjs', 'flightChartjsBar', 'flightMostBookedAirports'));
    }

}
