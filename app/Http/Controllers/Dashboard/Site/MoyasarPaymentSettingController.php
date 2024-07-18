<?php

namespace App\Http\Controllers\Dashboard\Site;

use App\Http\Controllers\Controller;
use App\Models\MoyasarPayment;
use App\Models\Setting;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class MoyasarPaymentSettingController extends Controller
{
    public function index()
    {
        $moyasar = MoyasarPayment::orderBy('id','desc')->first();
        return view('dashboard.pages.site.settings.moyasar.index', compact('moyasar'));
    }


    // تحديث القسم في قاعدة البيانات
    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required',
            'test_publishable_key' => 'required|string',
            'test_secret_key' => 'required|string',
            'live_publishable_key' => 'required|string',
            'live_secret_key' => 'required|string',
        ]);


        MoyasarPayment::orderBy('id','desc')->update([
            'status'=> $request->status,
            'test_publishable_key'=> $request->test_publishable_key,
            'test_secret_key'=> $request->test_secret_key,
            'live_publishable_key'=> $request->live_publishable_key,
            'live_secret_key'=> $request->live_secret_key,
        ]);

        Alert::success('Success', 'تم التعديل بنجاح');

        return redirect()->back();
    }
}
