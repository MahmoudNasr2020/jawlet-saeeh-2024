<?php

namespace App\Http\Controllers\Dashboard\Hotel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Hotel\HotelStoreRequest;
use App\Http\Requests\Dashboard\Hotel\HotelUpdateRequest;
use App\Http\Requests\Dashboard\RentalCar\RentalCarStoreRequest;
use App\Http\Requests\Dashboard\RentalCar\RentalCarUpdateRequest;
use App\Http\Trait\ImageTrait;
use App\Models\Hotel;
use App\Models\HotelReservation;
use App\Models\RentalCar;
use App\Models\RentalCarDepartments;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class HotelController extends Controller
{
    use ImageTrait;

    public function index()
    {
        $search = '';
        if (request()->has('search')) {
            $search = request('search');
            $hotels = Hotel::where('name', 'LIKE', "%{$search}%")
                ->orWhere('location', 'LIKE', "%{$search}%")
                ->orderBy('id','desc')
                ->paginate(10);

            $hotels->appends(['search' => $search]);
        }
        else
        {
            $hotels = Hotel::orderBy('id','desc')->paginate(10);
        }

        return view('dashboard.pages.hotels.index', compact('hotels', 'search'));
    }



    public function create()
    {
        $departments = RentalCarDepartments::select('id','name')->get();
        return view('dashboard.pages.hotels.create',compact('departments'));
    }

    public function show($id)
    {
        $today = Carbon::now();

        // البحث عن السيارة بواسطة المعرّف والتحقق من وجودها
        $hotel = Hotel::findOrFail($id);


        // إرسال البيانات إلى الواجهة
        return view('dashboard.pages.hotels.show', compact('hotel', ));
    }

    public function store(HotelStoreRequest $request)
    {

        $data = $request->except('_token');
        $data['main_image'] = $this->imageUpload('hotels',$request->image);

        if (!empty($request->kt_docs_repeater_basic)) {

            $publicUtilities = [];

            foreach ($request->kt_docs_repeater_basic as $item) {
                $utility = [];
                $utility['name'] = $item['public_utility_name'];

                if (isset($item['public_utility_image'])) {

                    $utility['image'] = $this->imageUpload('hotels', $item['public_utility_image']);
                }

                $publicUtilities[] = $utility;
            }

            $data['public_utility'] = json_encode($publicUtilities);
        }

        Hotel::create($data);

        Alert::success('Success', 'تمت الاضافة  بنجاح');
        return redirect()->route('dashboard.hotels.index');
    }

    public function edit($id)
    {
        $hotel = Hotel::findOrFail($id);
        return view('dashboard.pages.hotels.edit', compact('hotel'));
    }


    public function update(HotelUpdateRequest $request, $id)
    {
        $hotel = Hotel::findOrFail($id);
        $data = $request->except('_token', 'kt_docs_repeater_basic');

        // حذف وتحديث الصورة الرئيسية إذا تم رفع صورة جديدة
        if ($request->hasFile('image')) {
            $this->deleteImage($hotel->getRawOriginal('main_image'));
            $data['main_image'] = $this->imageUpload('hotels', $request->image);
        }

        // إعادة تعيين public_utility إلى null إذا كانت قائمة kt_docs_repeater_basic فارغة
        if (empty($request->kt_docs_repeater_basic)) {
            $data['public_utility'] = null; // إذا كانت القائمة فارغة، نضع القيمة null
        } else {
            $publicUtilities = [];

            $currentImages = !empty($hotel->public_utility) ? json_decode($hotel->getRawOriginal('public_utility'), true) : [];

            foreach ($request->kt_docs_repeater_basic as $index => $item) {
                $utility = [];
                $utility['name'] = $item['public_utility_name'];

                if (isset($item['public_utility_image'])) {

                    if (!empty($currentImages[$index]['image'])) {
                        $this->deleteImage($currentImages[$index]['image']);
                    }
                    $utility['image'] = $this->imageUpload('hotels', $item['public_utility_image']);
                } else {

                    $utility['image'] = $currentImages[$index]['image'] ?? null;
                }

                $publicUtilities[] = $utility;
            }

            $data['public_utility'] = empty($publicUtilities) ? null : json_encode($publicUtilities);
        }

        $hotel->update($data);

        Alert::success('Success', 'تم التعديل بنجاح');

        return redirect()->back();
    }




    public function destroy($id)
    {
        try {
            $hotel = Hotel::findOrFail($id);

            $this->deleteImage($hotel->getRawOriginal('main_image'));
            $imagesJson = $hotel->getRawOriginal('images');
            $images = json_decode($imagesJson, true);

            if (is_array($images)) {
                foreach ($images as $image) {
                    $this->deleteImage($image);
                }
            }

            if (!empty($hotel->getRawOriginal('public_utility'))) {
                $utilities = json_decode($hotel->getRawOriginal('public_utility'), true);

                if (is_array($utilities)) {
                    foreach ($utilities as $item) {
                        if (isset($item['image']) && !empty($item['image'])) {
                            $this->deleteImage($item['image']);
                        }
                    }
                }
            }

            $hotel->rooms()->delete();
            $hotel->delete();
            return 'done';
        }
        catch (\Exception $e) {
            // Log::error($e->getMessage());
            return response()->json(['error' => 'An error occurred while deleting the hotel.'], 500);
        }
    }



    public function multi_images($hotel_id)
    {
        $hotel = Hotel::findOrFail($hotel_id);
        $images = $hotel->images;
        return view('dashboard.pages.hotels.multi_images',compact('hotel_id','hotel','images'));
    }

    public function upload_multi_images(Request $request)
    {
        $hotel = Hotel::findOrFail($request->hotel_id);
        $images = [];
        if($hotel->images != null)
        {
            $images = json_decode($hotel->getRawOriginal('images'));
        }

        if($request->hasFile('file'))
        {
            $image = $this->imageUpload('hotels',$request->file);
            array_push($images,$image);
            $hotel->update(['images'=>json_encode($images)]);
            return response()->json(['image'=>asset('images/'.$image),'status'=>'success','code'=>200]);
        }
    }

    public function delete_image(Request $request)
    {
        $hotel = Hotel::find($request->hotel_id);
        if (!$hotel) {
            return response()->json(['status' => 'not_found', 'code' => 404], 404);
        }

        $images = json_decode($hotel->getRawOriginal('images'), true) ?? [];
        $new_images = [];
        $imageToDelete = $request->image;

        $parsedUrl = parse_url($imageToDelete);
        $relativePath = ltrim($parsedUrl['path'], '/');
        $relativePath = str_replace('images/', '', $relativePath);

        foreach ($images as $image) {
            $currentImageRelativePath = parse_url($image, PHP_URL_PATH);
            $currentImageRelativePath = ltrim($currentImageRelativePath, '/');
            $currentImageRelativePath = str_replace('images/', '', $currentImageRelativePath);

            if ($currentImageRelativePath != $relativePath) {
                $new_images[] = $image;
            }
            else
            {
                $this->deleteImage($relativePath);
            }
        }

        $hotel->update(['images' => $new_images ? json_encode($new_images) : null]);

        return response()->json(['status' => 'success', 'code' => 200], 200);
    }


    public function rooms(Request $request)
    {
        $hotels = Hotel::select('id', 'name')->get();

        if ($request->has('hotel_id')) {
            $hotel = Hotel::select('id', 'name')->findOrFail($request->hotel_id); // إيجاد الفندق أو إعادة صفحة 404
            $search = $request->input('search', '');

            $rooms = Room::where('hotel_id', $request->hotel_id);

            if (!empty($search)) {
                $rooms = $rooms->where('type', 'LIKE', "%{$search}%");
            }

            $rooms = $rooms->orderBy('id', 'desc')->paginate(10);
        } else {
            $hotel = null;
            $rooms = null;
        }

        return view('dashboard.pages.hotels.rooms', compact('rooms', 'hotel', 'hotels'));
    }


    public function overview()
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

        return view('dashboard.pages.hotels.overview',compact('chartjs','chartjsBar','chartjs_reservation','mostBookedHotels'));
    }
}
