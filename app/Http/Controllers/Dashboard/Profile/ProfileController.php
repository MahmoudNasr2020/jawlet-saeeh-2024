<?php

namespace App\Http\Controllers\Dashboard\Profile;

use App\Http\Controllers\Controller;
use App\Http\Trait\ImageTrait;
use App\Models\Admin;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class ProfileController extends Controller
{
    use ImageTrait;
    public function index()
    {
        return view('dashboard.pages.profile.index');
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:admins,email,'.auth()->guard('admin')->user()->id,
            'password' => 'nullable|string|min:8|confirmed',
            'image' => 'nullable|image|max:256',
        ]);

        $profile = Admin::findOrFail(auth()->guard('admin')->user()->id);

        $image = $profile->getRawOriginal('image');

        if ($request->hasFile('image')) {

            $this->deleteImage($profile->getRawOriginal('image'));
            $image = $this->imageUpload('admins',$request->image);
        }

        $profile->update([
            'name'=> $request->name,
            'email'=> $request->email,
            'password'=> $request->password != '' ? Hash::make($request->password) : $profile->password,
            'image'=> $image ?? $profile->getRawOriginal('image') ,
        ]);

        Alert::success('Success', 'تم التعديل بنجاح');

        return redirect()->back();
    }
}
