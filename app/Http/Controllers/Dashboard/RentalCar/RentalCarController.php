<?php

namespace App\Http\Controllers\Dashboard\RentalCar;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\RentalCar\RentalCarStoreRequest;
use App\Http\Requests\Dashboard\RentalCar\RentalCarUpdateRequest;
use App\Http\Trait\ImageTrait;
use App\Models\RentalCar;
use App\Models\RentalCarDepartments;
use Carbon\Carbon;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class RentalCarController extends Controller
{
    use ImageTrait;
    public function index()
    {
        if (request()->has('search')) {
            $search = request('search');
            $cars = RentalCar::with('rentalCarDepartment:id,name')
                ->where('name', 'LIKE', "%{$search}%")
                ->orWhere('location', 'LIKE', "%{$search}%")
                ->orWhereHas('rentalCarDepartment', function ($query) use ($search) {
                    $query->where('name', 'LIKE', "%{$search}%");
                })
                ->orderBy('id','desc')
                ->paginate(10);
        }
        else
        {
            $cars = RentalCar::with('rentalCarDepartment:id,name')->orderBy('id','desc')->paginate(10);
        }

        return view('dashboard.pages.rental_car.rental_cars.index', compact('cars'));
    }


    public function create()
    {
        $departments = RentalCarDepartments::select('id','name')->get();
        return view('dashboard.pages.rental_car.rental_cars.create',compact('departments'));
    }

    public function show($id)
    {
        $today = Carbon::now();

        // البحث عن السيارة بواسطة المعرّف والتحقق من وجودها
        $rental_car = RentalCar::with(['reservations' => function($query) use ($today) {
            // جلب الحجوزات التي تنتهي بعد اليوم أو تبدأ في المستقبل
            $query->where('end_datetime', '>=', $today->toDateString())
                ->orWhere('start_datetime', '>', $today->toDateString());
        }])->findOrFail($id);

        // فلترة الحجوزات الحالية
        $currentReservations = $rental_car->reservations->filter(function ($reservation) use ($today) {
            return $reservation->status == "1" && $reservation->start_datetime <= $today && $reservation->end_datetime >= $today;
        });

        // فلترة الحجوزات المقبلة
        $upcomingReservations = $rental_car->reservations->filter(function ($reservation) use ($today) {
            return  $reservation->status == "1" && $reservation->start_datetime > $today;
        });

        // فلترة الحجوزات المنتهية
        $pastReservations = $rental_car->reservations->filter(function ($reservation) use ($today) {
            return  $reservation->status == "1" && $reservation->end_datetime < $today;
        });

        // إرسال البيانات إلى الواجهة
        return view('dashboard.pages.rental_car.rental_cars.show', compact('rental_car', 'currentReservations', 'upcomingReservations', 'pastReservations'));
    }

    public function store(RentalCarStoreRequest $request)
    {

        $data = $request->except('_token');
        $data['main_image'] = $this->imageUpload('cars',$request->image);

        RentalCar::create($data);

        Alert::success('Success', 'تمت الاضافة  بنجاح');
        return redirect()->route('dashboard.rental-cars.index');
    }

    public function edit($id)
    {
        $car = RentalCar::findOrFail($id);
        $departments = RentalCarDepartments::select('id','name')->get();
        return view('dashboard.pages.rental_car.rental_cars.edit', compact('car','departments'));
    }

    // تحديث القسم في قاعدة البيانات
    public function update(RentalCarUpdateRequest $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:rental_car_departments,name,'.$id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $car = RentalCar::findOrFail($id);
        $data = $request->except('_token');

        if ($request->hasFile('image')) {

            $this->deleteImage($car->getRawOriginal('main_image'));
            $data['main_image'] = $this->imageUpload('cars',$request->image);
        }

        $car->update($data);

        Alert::success('Success', 'تم التعديل بنجاح');

        return redirect()->back();
    }

    public function destroy($id)
    {
        $car = RentalCar::findOrFail($id);
        $this->deleteImage($car->getRawOriginal('main_image'));
        $imagesJson = $car->getRawOriginal('images');
        $images = json_decode($imagesJson, true);

        if (is_array($images)) {
            foreach ($images as $image) {
                $this->deleteImage($image);
            }
        }

        $car->reservations()->delete();
        $car->delete();
        return 'done';
    }


    public function multi_images($rental_car_id)
    {
        $rental_car = RentalCar::findOrFail($rental_car_id);
        $images = $rental_car->images;
        return view('dashboard.pages.rental_car.rental_cars.multi_images',compact('rental_car_id','images'));
    }

    public function upload_multi_images(Request $request)
    {
        $car = RentalCar::findOrFail($request->rental_car_id);
        $images = [];
        if($car->images != null)
        {
             $images = json_decode($car->getRawOriginal('images'));
        }

        if($request->hasFile('file'))
        {
            $image = $this->imageUpload('cars',$request->file);
            array_push($images,$image);
            $car->update(['images'=>json_encode($images)]);
            return response()->json(['image'=>asset('images/'.$image),'status'=>'success','code'=>200]);
        }
    }

    public function delete_image(Request $request)
    {
        $car = RentalCar::find($request->rental_car_id);
        if (!$car) {
            return response()->json(['status' => 'not_found', 'code' => 404], 404);
        }

        $images = json_decode($car->getRawOriginal('images'), true) ?? [];
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

        $car->update(['images' => $new_images ? json_encode($new_images) : null]);

        return response()->json(['status' => 'success', 'code' => 200], 200);
    }

}
