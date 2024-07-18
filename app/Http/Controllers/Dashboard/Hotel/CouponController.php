<?php

namespace App\Http\Controllers\Dashboard\Hotel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Hotel\HotelCouponStoreRequest;
use App\Models\Coupon;
use App\Models\HotelCoupon;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class CouponController extends Controller
{
    public function index()
    {

        $search = '';
        if (request()->has('search')) {
            $search = request('search');
            $coupons = HotelCoupon::where('code', 'LIKE', "%{$search}%")
                ->orderBy('id','desc')
                ->paginate(10);

            $coupons->appends(['search' => $search]);
        }
        else
        {
            $coupons = HotelCoupon::orderBy('id','desc')->paginate(10);
        }

        return view('dashboard.pages.hotels.coupons.index', compact('coupons'));
    }


    public function create()
    {
        return view('dashboard.pages.hotels.coupons.create');
    }

    public function store(HotelCouponStoreRequest $request)
    {

        for ($i = 0; $i < $request->quantity; $i++) {
            $code = $this->generateUniqueCode();
            HotelCoupon::create([
                'code' => $code,
                'type' => $request->type,
                'discount_percentage' => $request->type === 'percentage' ? $request->discount_percentage : null,
                'maximum_discount' => $request->maximum_discount,
                'price' => $request->type === 'price' ? $request->price : null,
                'expiry_date' => $request->expiry_date,
                'usage_count' => 0,
                'usage_limit' => $request->usage_limit ?? 1
            ]);
        }

        Alert::success('Success', 'الكوبونات تم إنشاؤها بنجاح');
        return redirect()->route('dashboard.hotel-coupons.index');
    }



    public function edit($id)
    {
        $service = Service::findOrFail($id);
        return view('dashboard.pages.site.services.edit', compact('service'));
    }

    // تحديث القسم في قاعدة البيانات


    public function destroy($id)
    {
        $coupon = HotelCoupon::findOrFail($id);
        $coupon->delete();
        return 'done';
    }

    private function generateUniqueCode()
    {
        $code = Str::random(5);
        // تأكد من أن الرمز فريد
        while (HotelCoupon::where('code', $code)->exists()) {
            $code = Str::random(5);
        }
        return $code;
    }
}
